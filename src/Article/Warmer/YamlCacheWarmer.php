<?php

namespace App\Article\Warmer;


use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmer;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlCacheWarmer extends CacheWarmer
{

    public function isOptional()
    {
        return false;
    }

    public function warmUp($cacheDir)
    {
        try {
            $articles = Yaml::parseFile(__DIR__ .'/../Provider/articles.yaml')['data'];
            $this->writeCacheFile($cacheDir.'/yaml-articles.php', serialize($articles));
        } catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }
    }
}