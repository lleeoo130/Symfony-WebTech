<?php

namespace App\Controller\TechNews;


use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Member;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
     */
    public function newArticle()
    {

        # Getting an author | or session
        $member = $this ->getDoctrine()->getRepository(Member::class)
                        ->find(1);

        # Creating an article
        $article = new Article();
        $article->setAuthor($member);

        # Creating a form to add an article
        $form = $this->createFormBuilder($article)
                     ->add('title', TextType::class, [
                                    'required'      => true,
                                    'label'         => "Article Title",
                                    'attr'          => [
                                            'placeholder'   => "Article Title"
                                    ],
                         ])
                    ->add('content', CKEditorType::class, [
                                    'required'      => true,
                                    'label'         => false,
                        ])
                    ->add('featuredImage', FileType::class, [
                                    'required'      => true,
                                    'label'         => "Featured Image",
                                    'attr'          => ['class' => 'dropify']
                        ])
                    ->add('special', CheckboxType::class, [
                                    'required'      => false,
                                    'attr'          => [
                                        'data-toggle'   =>  'toggle',
                                        'data-on'       =>  'Yes',
                                        'data-off'      =>  'No',
                                    ]
                        ])
                    ->add('spotlight', CheckboxType::class, [
                                    'required'      => false,
                                    'attr'          => [
                                        'data-toggle'   =>  'toggle',
                                        'data-on'       =>  'Yes',
                                        'data-off'      =>  'No',
                                    ]
                        ])
                    ->add('category', EntityType::class, [
                                    'class'         => Category::class,
                                    'choice_label'  => 'name'
                        ])
                    ->add('author', EntityType::class, [
                                    'class'         => Member::class,
                                    'choice_label'  => function($member){
                                                            return $member->getFullName();
                                                    },
                    ])
                    ->add('New Author', ButtonType::class, [
                                        'attr'      => ['class'=>'btn-info'],
                        ])
                    ->add('Save Article', SubmitType::class, [
                                        'attr'      => ['class'=>'btn-success']
                        ])

                ->getForm();

        # Displaying the form
        return $this->render('article/form.html.twig', [
            'form'  => $form->createView()
        ]);
    }
}