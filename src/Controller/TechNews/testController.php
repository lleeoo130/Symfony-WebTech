<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 20/11/2018
 * Time: 10:40
 */

namespace App\Controller\TechNews;


use App\Article\DataArticles\ArticleCatalogue;
use App\Article\DataArticles\DoctrineSource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class testController extends AbstractController
{

    /**
     * @Route("/lol-test", name="lol")
     * @param ArticleCatalogue $catalogue
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function lol(ArticleCatalogue $catalogue)
    {

        $articles = $catalogue->findAll();

        dump($articles);

        return $this->render('test.html.twig', [
            'active' => 'index'
        ]);
    }
}