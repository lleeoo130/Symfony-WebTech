<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{

    const MAX_RESULTS = 5;
    const MAX_SUGGESTIONS = 3;


    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article[]
     */
    public function getArticles()
    {
        return $this->findAll();
    }


    /**
     * Gets our last $n articles.
     */
    public function findLatestArticles()
    {
        return $this->createQueryBuilder('a')
                    ->orderBy('a.id', 'DESC')
                    ->setMaxResults(self::MAX_RESULTS)
                    ->getQuery()
                    ->getResult();
    }


    /**
     * Returns articles from a category, except for the given article, 3 max, DESC
     * @param $idArticle
     * @param $idCategory
     * @return mixed
     */
    public function findArticlesSuggestions($idArticle, $idCategory)
    {
        return $this->createQueryBuilder('a')
                    ->andWhere('a.category = :category')
                    ->andWhere( 'a.id != :id')
                    ->setParameters(['category' =>  $idCategory, 'id' => $idArticle])
                    ->setMaxResults(self::MAX_SUGGESTIONS)
                    ->orderBy('a.id', 'DESC')
                    ->getQuery()
                    ->getResult();
    }


    /**
     * Returns article.spotlight = true
     * @return mixed
     */
    public function findSpotlightArticles()
    {
        return $this->createQueryBuilder('a')
                    ->andWhere('a.spotlight = :true')
                    ->setParameter('true', true)
                    ->getQuery()
                    ->getResult();
    }


    /**
     * Returns article.special = true
     * @return mixed
     */
    public function findSpecialArticles()
    {
        return $this->createQueryBuilder('a')
                    ->andWhere('a.special = :true')
                    ->setParameter('true', true)
                    ->getQuery()
                    ->getResult();
    }


    public function countArticles()
    {
        try{
            return $this->createQueryBuilder('a')
                        ->select('COUNT(a)')
                        ->getQuery()
                        ->getSingleScalarResult();
        } catch (NonUniqueResultException $e)
        {
            return 0;
        }

    }



    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
