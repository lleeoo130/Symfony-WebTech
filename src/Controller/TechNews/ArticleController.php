<?php

namespace App\Controller\TechNews;


use App\Article\ArticleRequest;
use App\Article\ArticleRequestHandler;
use App\Article\ArticleRequestUpdateHandler;
use App\Article\ArticleType;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Member;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController
 * @package App\Controller\TechNews
 */
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
        $article->setContent("<p>It's finally about time that we bought a new video projector for Nicolas' class.</p>");
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

    /**
     * Form to add an article
     *
     * @Route("/create-new-article",
     *          name="article_new")
     * @Security("has_role('ROLE_AUTHOR')")
     * @param Request $request
     * @param ArticleRequestHandler $articleRequestHandler
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newArticle(Request $request, ArticleRequestHandler $articleRequestHandler)
    {

        # Getting an author | or session
        $member = $this ->getUser();

        # Creating an article
        # $article = new Article();
        # $article->setAuthor($member);
        $article = new ArticleRequest($member);


        # Creating a form to add an article
        $form = $this   ->createForm(ArticleType::class, $article)
                        ->handleRequest($request);

        # Handling POST data
        /*$form->handleRequest($request);*/

        # Checking forms's data
        if ($form->isSubmitted() && $form->isValid())
        {

            $article = $articleRequestHandler->handle($article);

            # Flash Message:
            $this->addFlash('notice',
                'Congrats! You\'re article is now online');

            # Redirecting to article
            return $this->redirectToRoute('index_article', [
                "category"  => $article->getCategory()->getSlug(),
                "slug"      => $article->getSlug(),
                "id"        => $article->getId()
            ]);

        }

        # Displaying the form
        return $this->render('article/form.html.twig', [
            'form'  => $form->createView()
        ]);
    }


    /**
     * @Route("edit-article/{id<\d+>}",
     *          name="article_edit")
     * @Security("has_role('ROLE_AUTHOR')")
     * @param Article $article
     * @param Request $request
     * @param Packages $packages
     * @return string
     */
    public function editArticle(Article $article, Request $request, Packages $packages, ArticleRequestUpdateHandler $updateHandler)
    {
        # Getting ArticleRequest from article
        $ar = ArticleRequest::createFromArticle($article,
                                                $this->getParameter('articles_dir'),
                                                $this->getParameter('articles_assets_dir'),
                                                $packages);

        # Creating form:
            # Options:
        $options = [ 'img_url' =>  $ar->getImgUrl() ];


        $form = $this   ->createForm(ArticleType::class, $ar, $options)
                        ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            # Handling and saving data:
            $article = $updateHandler->handle($ar, $article);

            # Message Flash:
            $this->addFlash('notice', 'Editing complete!');

            return $this->redirectToRoute('article_edit', [
                'id'    =>  $article->getId()
            ]);

        }

        # Display form into the view:
        return $this->render('article/form.html.twig', [
                                        'form' => $form->createView()
        ]);

    }
}