<?php

namespace App\Article;


use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ArticleRequestUpdateHandler
{
    private $em, $articleAssetsDir;

    public function __construct(ObjectManager $manager, string $articleAssetsDir)
    {
        $this->em               = $manager;
        $this->articleAssetsDir = $articleAssetsDir;
    }

    public function handle(ArticleRequest $request, Article $article): Article
    {

        $file = $request->getFeaturedImage();

        if (null !== $file)
        {
            $fileName = $request->getSlug() . '_' . $file->getClientOriginalName();

                try{
                    $file->move(
                        $this->articleAssetsDir,
                        $fileName
                    );
                }
                catch (FileException $e)
                {
                }

            $request->setFeaturedImage($fileName);
        }
        else{
            $request->setFeaturedImage($article->getFeaturedImage());
        }


        # Updating data:
        $article->update(
            $request->getTitle(),
            $request->getSlug(),
            $request->getContent(),
            $request->getFeaturedImage(),
            $request->getSpecial(),
            $request->getSpotlight(),
            $request->getCategory()
        );

        $this->em->flush();

        return $article;

    }

}