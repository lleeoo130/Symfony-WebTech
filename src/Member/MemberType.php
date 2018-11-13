<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 13/11/2018
 * Time: 10:00
 */

namespace App\Member;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('firstName', TextType::class, [
                                                    'label'     => 'Your first name:',
                                                    'required'  => 'false',
                                                    'attr'      => [
                                                        'placeholder'   => 'First name...'
                                                    ]
                ])
                ->add('lastName', TextType::class, [
                                                    'label'     => 'Your last name:',
                                                    'required'  => 'false',
                                                    'attr'      =>  [
                                                        'placeholder'   => 'Last name...'
                                                    ]
                ])
                ->add('email', EmailType::class, [
                                                    'label'     => 'Your email:',
                                                    'required'  => 'false',
                                                    'attr'      => [
                                                        'placeholder'   => 'Email...'
                                                    ]
                ])
                ->add('password', PasswordType::class, [
                                                    'label'     => 'Your password...',
                                                    'required'  => 'false',
                                                    'attr'      => [
                                                        'placeholder'   => 'Password'
                                                    ]
                ])
                ->add('conditions', CheckboxType::class, [
                                                    'label'     => 'Accepting Term of Use',
                                                    'required'  => 'false',
                                                    'attr'      => [
                                                        'data-toggle'   => 'toggle',
                                                        'data-on'       => 'Yes',
                                                        'data-off'      => 'No'
                                                    ]
                ])
                ->add('Submit', SubmitType::class, [
                                                    'label'     => 'Create my account'
                ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MemberRequest::class
        ]);
    }


}