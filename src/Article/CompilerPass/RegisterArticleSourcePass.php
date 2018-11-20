<?php

namespace App\Article\CompilerPass;


use App\Article\DataArticles\ArticleCatalogue;
use App\Entity\Article;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterArticleSourcePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {


        if (!$container->hasDefinition(Article::class)){
            return;
        }

        $articleCatalogueDefinition = $container->getDefinition(ArticleCatalogue::class);
        $taggedServices = $container->findTaggedServiceIds('app.article_source');

        foreach ($taggedServices as $source => $tags)
        {
            $articleCatalogueDefinition->addMethodCall('addSource', [
                new Reference($source)
            ]);
        }
    }
}