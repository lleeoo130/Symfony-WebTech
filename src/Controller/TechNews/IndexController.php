<?php


namespace App\Controller\TechNews;



use App\Article\Provider\YamlProvider;
use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends Controller
{

    /**
     *  Our website's index page.
     */
    public function index()
    {
        // getting the articles from YamlProvider
        $articles = $this->getDoctrine()->getRepository(Article::class)->findLatestArticles();

        $spotlights = $this->getDoctrine()->getRepository(Article::class)->findSpotlightArticles();

        $specials   = $this->getDoctrine()->getRepository(Article::class)->findSpecialArticles();

        // return new Response("<html><body><h1>Welcome</h1></body></html>");
        return $this->render('index/index.html.twig', [
            'articles'      => $articles,
            'spotlights'    => $spotlights,
            'specials'      => $specials,
        ]);
    }

    /**
     *  Page showing the articles of a category.
     * @Route("/category/{category<\w+>}",
     *          name="index_category",
     *          methods={"GET"},
     *          requirements={},
     *          defaults={"category": "Breaking-News"})
     * @param $category
     * @return Response
     */
    public function category($category)
    {

        // Getting the category
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['slug' => $category]);

        $articles = $category->getArticles();

        return $this->render('index/category.html.twig', [
            'category'  =>  $category,
            'articles'  =>  $articles
        ]);
    }

    /**
     * Display an article
     * @Route("/{category<\w+>}/{slug}_{id<\d+>}.html",
     *          name="index_article")
     * @param Article $article
     * @return Response
     */
    public function articles(Article $article = null)
    {
        /*$article = $this->getDoctrine()
                        ->getRepository(Article::class)
                        ->find($id);*/

        if (null === $article)
        {
            /*throw $this->createNotFoundException('Article id:'.$id.' not found');*/

             return $this->redirectToRoute('index', [], Response::HTTP_MOVED_PERMANENTLY);
        }

        $suggestions = $this->getDoctrine()
                            ->getRepository(Article::class)
                            ->findArticlesSuggestions($article->getId(), $article->getCategory()->getId());



        return $this->render("index/articles.html.twig", [
            'article'       => $article,
            'suggestions'   => $suggestions,
        ]);
    }


    /**
     * @return Response
     */
    public function sidebar()
    {
        # Getting the repository:
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);

        # Getting the latest articles
        $articles = $articleRepository->findLatestArticles();

        # Getting the special articles
        $specials = $articleRepository->findSpecialArticles();

        # Returning the view
        return $this->render('component/_sidebar.html.twig', [
            'articles' => $articles,
            'specials' => $specials
        ]);
    }

}