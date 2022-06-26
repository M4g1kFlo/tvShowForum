<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SelfType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('last_name', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Last name'
            ])
            ->add('first_name', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'First name'
            ])
            ->add('adress', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Address'
            ])
            ->add('zip_code', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'ZIP_code'
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'City'
            ])
            ->add('mail', EmailType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Mail'
            ])
            ->add('phone', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Phone'
            ])
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Nickname'
            ])
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
