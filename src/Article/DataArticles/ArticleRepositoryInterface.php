<?php

namespace App\Article\DataArticles;


use App\Entity\Article;

/**
 * Interface ArticleRepositoryInterface
 * @package App\Article\DataArticles
 */
interface ArticleRepositoryInterface
{
    /**
     * @param int $id
     * @return Article|null
     */
    public function find(int $id): ?Article;

    /**
     * @return iterable|null
     */
    public function findAll(): ?iterable;

    /**
     * @return iterable|null
     */
    public function findLatestArticles(): ?iterable;

    /**
     * Returns the number of articles for each source - stats.
     * @return int
     */
    public function count(): int;
}