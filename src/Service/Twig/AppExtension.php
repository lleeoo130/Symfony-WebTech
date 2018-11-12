<?php

namespace App\Service\Twig;


use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{

    private $em;
    public const NB_SUMMARY_CHAR = 170;

    /**
     * AppExtension constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        // Injecting the EM in our class.
        $this->em = $manager;
    }

    public function getFunctions()
    {
        return [
            new \Twig_Function('getCategories', function () {

                return $this->em->getRepository(Category::class)->findCategoriesHavingArticles();
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