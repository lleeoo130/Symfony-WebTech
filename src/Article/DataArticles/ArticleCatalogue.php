<?php

namespace App\Article\DataArticles;


use App\Entity\Article;
use App\Exception\DuplicateCatalogueArticleException;
use Tightenco\Collect\Support\Collection;

/**
 * Class ArticleCatalogue
 * @package App\Article\DataArticles
 */
class ArticleCatalogue implements ArticleCatalogueInterface
{

    /**
     * @var array
     */
    private $sources = [];


    public function __construct(YamlSource $yamlSource, DoctrineSource $doctrineSource)
    {
        $this->addSource($yamlSource);
        $this->addSource($doctrineSource);
    }

    /**
     * @param ArticleAbstractSource $source
     * @return int|mixed
     */
    public function addSource(ArticleAbstractSource $source): void
    {
        if (!in_array($source, $this->sources))
        {
            $this->sources[] = $source;
        }
    }

    /**
     * @param iterable $sources
     * @return mixed|void
     */
    public function setSources(Iterable $sources): void
    {
        $this->sources[] = $sources;
    }

    /**
     * @return array|mixed
     */
    public function getSources(): iterable
    {
        return $this->sources;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id): Article
    {
        $articles = new Collection();

        /**
         * @var ArticleAbstractSource $source
         */
        foreach($this->sources as $source)
        {
            $article = $source->find($id);

            # If the source has a result
            if (null !== $article)
            {
                $articles[] = $article;
            }

            if ($articles->count() > 1)
            {
                throw new DuplicateCatalogueArticleException(
                    sprintf(
                        'Return value %s cannot return more than one record on line %s',
                        get_class($this).'::'.__FUNCTION__.'()', __LINE__
                    ));
            }
        }
        return $articles->pop();
    }

    /**
     * @return mixed
     */
    public function findAll(): iterable
    {
        return $this->sourcesIterator('findAll')
                    ->sortByDesc(function($col) {
                        return $col->getDateCreation();
                    })
                    ->sortBy('dateCreation');
    }

    /**
     * @return iterable|null
     */
    public function findLatestArticles(): ?iterable
    {
        return $this->sourcesIterator('findLatestArticles')
                    ->sortByDesc(function($col) {
                        return $col->getDateCreation();
                    })
                    ->slice(-5);
    }

    /**
     * Go through sources
     * @param string $callback
     * @return Collection
     */
    private function sourcesIterator(string $callback) :Collection
    {
        $articles = New Collection();

        dump($this->sources);

        /**
         * @var ArticleAbstractSource $source
         * @var Article $article
         */
        foreach ($this->sources as $source)
        {
                foreach ($source->$callback() as $article)
                {
                    $articles[] = $article;
                }
            }
        return $articles;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return null;
    }


}