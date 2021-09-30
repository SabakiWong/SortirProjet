<?php

namespace App\Form;

use App\Data\InfoRecherche;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('campus', ChoiceType::class, [
                'expanded' => false,
                'multiple' =>false,
                'required' => true,
                'choices' => [
                    'Saint-Herblain' => 1,
                    '22222' => 2,
                    '33333' => 3, //todo: Changer les noms des campus

                ]
            ])
            ->add('motCle', TextType::class, [
            'label' => 'Le nom de la sortie contient:',
            'required' => false,
            'attr' => [
                'placeholder' => 'Écrivez ici'
                ]
            ])
            ->add('dateDebut', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'Entre: ',
                'widget' => 'choice',
                //'input' => 'datetime_immutable',
                'required' => true
            ])
            ->add('dateFin', \Symfony\Component\Form\Extension\Core\Type\DateType::class, [
                'label' => 'et: ',
                'widget' => 'choice',
                //'input' => 'datetime_immutable',
                'required' => true
            ])
            ->add('estOrganisateur', CheckboxType::class, [
                'label'=> 'Sorties dont je suis l\'organisateur/trice: ',
                'required'=>false
            ])
            ->add('estInscrit', CheckboxType::class, [
                'label'=> 'Sorties auxquelles je suis inscrit/e: ',
                'required'=>false
            ])
            ->add('estPassee', CheckboxType::class, [
                'label'=> 'Sorties passées: ',
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InfoRecherche::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}