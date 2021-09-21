<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GererMonProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Pseudo', TextType::class)
            ->add('Prenom', TextType::class)
            ->add('Nom', TextType::class)
            ->add('Telephone', TelType::class)
            ->add('Email', EmailType::class)
            ->add('Mdp', PassewordType::class)
            ->add('Confirmation', PassewordType::class)
            ->add('Campus', ChoiceType::class,[
                'choices' =>[
                    'Rennes' =>'Rennes',
                    'Saint Herblain' =>'Saint Herblain',
                    'Niort' => 'Niort',
                    'Quimper' => 'Quimper'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
