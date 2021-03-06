<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Topic;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class TopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder
        //     ->add('title')
        //     ->add('content')
        //     ->add('category', Category::class, [
        //                 'attr' => [
        //                     'class' => 'form-control mb-3',
        //                 ],
        //                 'label' => 'Catégorie'
        //             ])
        // ;
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Titre'
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'rows' => '5',
                    'style' => 'height:100%'
                ],
                'label' => 'Contenu'
            ])
            ->add('category', EntityType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Catégorie',
                'class' => Category::class,
                'choice_label' => 'title',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Topic::class,
        ]);
    }
}
