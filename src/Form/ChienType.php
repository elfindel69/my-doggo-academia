<?php

namespace App\Form;

use App\Entity\Chien;
use App\Entity\Race;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'nom',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'age',
                IntegerType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'taille',
                IntegerType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'poids',
                IntegerType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'lof',
                ChoiceType::class,
                [
                    'choices' => [
                        'Oui' => true,
                        'Non' => false
                    ]
                ]
            )
            ->add(
                'sociable',
                ChoiceType::class,
                [
                    'choices' => [
                        'Oui' => true,
                        'Non' => false
                    ]
                ]
            )
            ->add(
                'antecedents',
                TextareaType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'sexe',
                ChoiceType::class,
                [
                    'choices' => [
                        'Male' => 'Male',
                        'Femelle' => 'Femelle'
                    ]
                ]
            )
            ->add('races',
                EntityType::class,
                [
                'class' => Race::class,
                'choice_label' => 'nom',
                'multiple' => true,
                ]

            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chien::class,
        ]);
    }
}
