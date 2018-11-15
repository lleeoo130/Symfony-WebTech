<?php

namespace App\Service\Twig;


use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{

    private $em, $session;
    public const NB_SUMMARY_CHAR = 170;

    /**
     * AppExtension constructor.
     * @param EntityManagerInterface $manager
     * @param SessionInterface $session
     */
    public function __construct(EntityManagerInterface $manager,
                                SessionInterface $session)
    {
        // Injecting the EM in our class.
        $this->em       = $manager;
        $this->session  = $session;
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('getCategories', function () {

                return $this->em->getRepository(Category::class)->findCategoriesHavingArticles();
            }),

            new \Twig_Function('isUserInvited', function (){

                return $this->session->get('inviteUserModal');
            })

        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_Filter('summary', function ($content){

                $content = strip_tags($content);

                if (strlen($content) > self::NB_SUMMARY_CHAR)
                {
                    $contentCut = substr($content, 0, self::NB_SUMMARY_CHAR);
                    $content = substr($contentCut, 0, strrpos($contentCut, ' ')) . '...';
                }
                return $content;
            }, ['is_safe' => ['html']])
        ];
    }

}