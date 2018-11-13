<?php

namespace App\Article;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

class ArticleRequestHandler
{
    private $em, $articleFactory;

    public function __construct(EntityManagerInterface $em, ArticleFactory $articleFactory)
    {
        $this->em = $em;
        $this->articleFactory = $articleFactory;
    }


    public function handle(ArticleRequest $request): ?Article
    {

        # Handling the image upload
        $request->uploadImage();

        # Updating slug
        $request->setSlug();

        # Appel de la factory
        $article = $this->articleFactory->createFromArticleRequest($request);

        # Saving in Doctrine
        $this->em->persist($article);
        $this->em->flush();

        return $article;
    }
}