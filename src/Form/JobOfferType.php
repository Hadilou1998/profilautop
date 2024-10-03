<?php

namespace App\Form;

use App\Entity\JobOffer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class JobOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du poste',
            ])
            ->add('company', TextType::class, [
                'label' => 'Nom de l\'entreprise',
            ])
            ->add('link', TextType::class, [
                'required' => false,
                'label' => 'Lien vers le poste',
            ])
            ->add('location', TextType::class, [
                'required' => false,
                'label' => 'Lieu du poste',
            ])
            ->add('salary', TextType::class, [
                'required' => false,
                'label' => 'Fourchette de salaire',
            ])
            ->add('contactPerson', TextType::class, [
                'required' => false,
                'label' => 'Nom du contact dans l\'entreprise',
            ])
            ->add('contactEmail', TextType::class, [
                'required' => false,
                'label' => 'Email du contact',
            ])
            ->add('applicationDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de candidature',
            ])
            ->add('status', TextType::class, [
                'label' => 'Statut de la candidature',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => JobOffer::class,
        ]);
    }
}