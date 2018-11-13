<?php

namespace App\Article;

use App\Entity\Article;


class ArticleFactory
{

    /**
     * @param ArticleRequest $request
     * @return Article
     */
    public function createFromArticleRequest(ArticleRequest $request): Article
    {
        return new Article(
            $request->getId(),
            $request->getTitle(),
            $request->getSlug(),
            $request->getContent(),
            $request->getFeaturedImage(),
            $request->getSpecial(),
            $request->getSpotlight(),
            $request->getCategory(),
            $request->getAuthor(),
            $request->getDateCreation()
        );
    }

}