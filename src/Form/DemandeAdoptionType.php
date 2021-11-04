<?php

namespace App\Form;

use App\Entity\Chien;
use App\Entity\DemandeAdoption;
use App\Repository\ChienRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeAdoptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $id = $options['id'];
        $builder
            ->add('chiens', EntityType::class, [
                'class' => Chien::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
                'required' => true,
                'query_builder' => function (ChienRepository $repo) use ($id) {
                    return $repo->findChienNonAdopteFromAnnonceId($id);
                }
            ])
            ->add('messages', CollectionType::class,
                [
                    'entry_type' => EnvoiMessageType::class,
                    'required' => true,
                    'by_reference' => false,
                    'label' => false,
                    'entry_options' => ["label" => false]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('id')
            ->setDefaults([
                'data_class' => DemandeAdoption::class,
            ]);
    }
}
