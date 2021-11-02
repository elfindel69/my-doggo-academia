<?php

namespace App\Form;

use App\Entity\Chien;
use App\Entity\DemandeAdoption;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeAdoptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('chiens', EntityType::class, [
                'class' => Chien::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'required' => true,
                'query_builder' => function (EntityRepository $er){
                    return $er->createQueryBuilder('c')
                    ->where('c.annonce.id', ':annonceId')
                    ->setParameter('annonceId', );
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DemandeAdoption::class,
        ]);
    }
}
