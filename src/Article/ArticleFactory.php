<?php

namespace App\Article;

use App\Controller\HelperTrait;
use App\Entity\Article;


class ArticleFactory
{

    use HelperTrait;

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

    public function createFromYamlArticle($YamlArticle): Article
    {
        $date = new \DateTime();
        $date->setTimestamp($YamlArticle['datecreation']);

        return new Article(
            $this->getUniqId(),
            $YamlArticle['titre'],
            $this->slugify($YamlArticle['titre']),
            $YamlArticle['contenu'],
            $YamlArticle['featuredimage'],
            $YamlArticle['special'],
            $YamlArticle['spotlight'],
            $YamlArticle['categorie'],
            $YamlArticle['auteur'],
            $date
        );
    }

}