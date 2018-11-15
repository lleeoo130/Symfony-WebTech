<?php

namespace App\Newsletter;


use App\Entity\Newsletter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class, [
            'label' => false,
            'attr'  => [
                'placeholder' => 'Your email goes right there.',
            ]
        ])
                ->add('submit', SubmitType::class, [
            'label' => 'Subscribe'
        ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault(
                'data_class', Newsletter::class
        );
    }

}