<?php

namespace App\Article\Provider;


use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlProvider
{

    /**
     * Returns the articles from articles.yaml as an array
     */
    public function getArticles()
    {
        try {
            return Yaml::parseFile(__DIR__ .'/articles.yaml')['data'];
        } catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }
    }


}