<?php

namespace App\Article;


use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ArticleType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


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
                'attr'          => [
                                    'class'             => 'dropify',
                                    'data-default-type' => $options['img_url']
                                    ]
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
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            # 'data_class' => Article::class,
            'data_class' => ArticleRequest::class,
            'img_url'    => null
            ]);
    }

}