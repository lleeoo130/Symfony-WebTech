<?php

namespace App\Article\EvenListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ArticleTypeSlugFieldSubscriber implements EventSubscriberInterface
{

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData'
        ];
    }

    public function preSetData(FormEvent $event)
    {
        $article    = $event->getData();
        $form       = $event->getForm();

        # Making sure there's a slug
        if (null !== $article->getSlug())
        {
            # Adding slug input:
            $form->add('slug', TextType::class, [
                                                'label' => 'Article\'s slug',
                                                'attr'  =>  [
                                                    'placeholder' => "Article's slug"
                                                ]
            ]);
        }
    }
}