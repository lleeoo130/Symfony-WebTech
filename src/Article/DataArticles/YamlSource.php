<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 20/11/2018
 * Time: 10:03
 */

namespace App\Article\DataArticles;

use App\Article\ArticleFactory;
use App\Article\Provider\YamlProvider;
use App\Controller\HelperTrait;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Member;
use Tightenco\Collect\Support\Collection;

class YamlSource extends ArticleAbstractSource
{

    use HelperTrait;

    private $articles;


    /**
     * YamlSource constructor.
     * @param YamlProvider $provider
     */
    public function __construct(YamlProvider $provider)
    {

        $this->articles = new Collection($provider->getArticles());

        # foreach ( $provider->getArticles() as $article)
        # {
        #    $this->articles[] = $this->createArticleFromArray($article);
        # }
    }


    public function find(int $id): Article
    {
        $article = $this->articles->firstWhere('id', $id);

        return $article == null ? null : $this->createArticleFromArray($article);
    }

    public function findAll(): iterable
    {
        $articles = new Collection();

        foreach ($this->articles as $article)
        {
            $articles[] = $this->createArticleFromArray($article);
        }

        return $articles;
    }

    protected function createArticleFromArray(iterable $article): ?Article
    {
        $tmp = (object)$article;

        //TODO: Watch out for different IDs:

        # Setting Categories
        $category = new Category();
        $category->setId($tmp->categorie['id']);
        $category->setName($tmp->categorie['libelle']);
        $category->setSlug($this->slugify($tmp->categorie['libelle']));

        # Setting User:
        $member = new Member();
        $member->setFirstName($tmp->auteur['prenom']);
        $member->setLastName($tmp->auteur['nom']);
        $member->setEmail($tmp->auteur['email']);

        # Creating a new Article:
        $date = new \DateTime();
        return new Article(
            $tmp->id,
            $tmp->titre,
            $this->slugify($tmp->titre),
            $tmp->contenu,
            $tmp->featuredimage,
            $tmp->special,
            $tmp->spotlight,
            $category,
            $member,
            $date->setTimestamp($tmp->datecreation)
        );

    }

    public function findLatestArticles(): ?iterable
    {
        /**
         * @var Collection $articles
         */
        $articles = $this->findAll();

        return $articles->sortBy('datecreation')
                        ->slice(-5);

    }

    public function count(): int
    {
        return $this->articles->count();
    }


}