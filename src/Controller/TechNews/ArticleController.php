<?php

namespace App\Controller\TechNews;


use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Member;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * Demonstrate how to add an article with Doctrine (Data Mapper).
     * @Route("test/article/add", name="article_test")
     */
    public function test()
    {
        // Create a new category
        $category = new Category();
        $category->setName("Economics");
        $category->setSlug("economics");

        // Create a Member (the article's author)
        $member = new Member();
        $member->setFirstName('Fabien');
        $member->setLastName('BRIVE');
        $member->setEmail("f.brive@tech.news");
        $member->setPassword("monchatfaitdescalins");
        $member->setRole(['ROLE_AUTEUR']);

        //Create a new Article
        $article = new Article();
        $article->setTitle("WF3 in urge to buy new video-projector");
        $article->setSlug("wf3-in-urge-to-buy-a-new-video-projector");
        $article->setContent("<p>It's finally about timethat whe buy a new video projector for Nicolas' formation.</p>");
        $article->setFeaturedImage("7.jpg");
        $article->setSpecial(0);
        $article->setSpotlight(1);

        // Associate category and author to the article;
        $article->setCategory($category);
        $article->setAuthor($member);

        // Saving it all with Doctrine
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->persist($member);
        $em->persist($article);
        $em->flush();

        // Showing the response
        return new Response('New article created, ID: '
                            . $article->getId()
                            . ' in category '
                            . $category->getName()
                            . ' written by '
                            . $member->getFirstName()
            );
    }

    public function newArticle()
    {
        
    }
}