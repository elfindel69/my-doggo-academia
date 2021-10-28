<?php

namespace App\Form;

use App\Entity\Adoptant;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdoptantCompleteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['required' => true])
            ->add('nom', TextType::class, ['required' => true])
            ->add('adresse', TextType::class, ['required' => true])
            ->add('ville', EntityType::class, [
                'required' => true,
                'class' => Ville::class,
                'choice_label' => 'nom',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('telephone', TextType::class, ['required' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adoptant::class,
        ]);
    }
}
