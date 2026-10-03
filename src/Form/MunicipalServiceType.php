<?php

namespace App\Form;

use App\Entity\MunicipalService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MunicipalServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du service',
                'attr' => [
                    'placeholder' => 'Ex. Service de l’état civil',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Décrivez le rôle de ce service...',
                    'rows' => 4,
                ],
            ])
            ->add('category', TextType::class, [
                'label' => 'Catégorie',
                'attr' => [
                    'placeholder' => 'Ex. Administration',
                ],
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex. Hôtel de Ville',
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
                'attr' => [
                    'placeholder' => '+269 ...',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'required' => false,
                'attr' => [
                    'placeholder' => 'service@terranova.local',
                ],
            ])
            ->add('openingHours', TextType::class, [
                'label' => 'Horaires d’ouverture',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex. Lundi - Vendredi : 08h00 - 15h00',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MunicipalService::class,
        ]);
    }
}
