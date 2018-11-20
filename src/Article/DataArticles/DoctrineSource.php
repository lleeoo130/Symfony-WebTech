<?php

namespace App\Article\DataArticles;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;

class DoctrineSource extends ArticleAbstractSource
{


    /**
     * @var ArticleRepository $repository
     */
    private $repository;
    private $entity = Article::class;


    /**
     * DoctrineSource constructor.
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->repository = $em->getRepository($this->entity);

    }


    /**
     * @param int $id
     * @return Article|null
     */
    public function find(int $id): ?Article
    {
        return $this->repository->find($id);
    }

    /**
     * @return iterable
     */
    public function findAll(): iterable
    {
        return $this->repository->findAll();
    }



    protected function createArticleFromArray(iterable $article): ?Article
    {
        return null;
    }

    public function findLatestArticles(): ?iterable
    {
       return $this->repository->findLatestArticles();
    }

    public function count(): int
    {
        return $this->repository->countArticles();
    }


}