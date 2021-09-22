<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GererMonProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class,[
                 'label'=> 'Pseudo :'
            ])
            ->add('prenom', TextType::class,[
                'label'=> 'Prenom :'
            ])
            ->add('nom', TextType::class,[
                'label' => 'Nom :'
            ])
            ->add('telephone', TelType::class,[
                'label' => 'Telephone :'
            ])
            ->add('email', EmailType::class,[
                'label' => 'Email :'
            ])
            ->add('password', PasswordType::class,[
                'label' => 'Mot de passe :'
            ])


            ->add('campus', ChoiceType::class,[
                'label' => 'Campus :',
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
            'data_class' => Utilisateur::class,
        ]);
    }
}
