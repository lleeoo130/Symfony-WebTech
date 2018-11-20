<?php

namespace App\Article\DataArticles;


/**
 * Interface ArticleCatalogueInterface
 * @package App\Article\DataArticles
 */
interface ArticleCatalogueInterface extends ArticleRepositoryInterface
{
    /**
     * @param ArticleAbstractSource $source
     * @return mixed
     */
    public function addSource(ArticleAbstractSource $source): void;

    /**
     * @param iterable $source
     * @return mixed
     */
    public function setSources(Iterable $source): void;

    /**
     * @return mixed
     */
    public function getSources():iterable;
}