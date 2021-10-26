<?php

namespace App\Form;

use App\Entity\Adoptant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdoptantFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'email',
                TextType::email,
                [
                    'required' => true,
                ]
            )
            ->add(
                'password',
                TextType::password, // On peut lui donner un type (ici, on dit que c'est un input de type text
                [
                    'required' => true, // On passe une option, pour préciser que ce champ est requis (ne doit pas être vide)
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adoptant::class,
        ]);
    }
}