<?php

namespace App\Article\DataArticles;


use App\Entity\Article;

abstract class  ArticleAbstractSource implements ArticleRepositoryInterface
{

    protected $mediator;

    protected function setMediator($mediator){
        $this->mediator = $mediator;
    }

    abstract protected function createArticleFromArray(iterable $article): ?Article;
}