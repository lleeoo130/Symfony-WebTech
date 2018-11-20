<?php

namespace App\Article\Provider;


use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;


class YamlProvider
{

    private $kernel;

    /**
     * YamlProvider constructor.
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Returns the articles from articles.yaml as an array
     */
    public function getArticles()
    {
        $articles = unserialize( file_get_contents(
                $this->kernel->getCacheDir() . '/yaml-articles.php'
        ));

        return $articles;
    }

}