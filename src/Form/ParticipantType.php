<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nom',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Veuillez inserer votre nom',
                    'class'=>'nom'
                ]
            ])

            ->add('nomEvenement',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Veuillez inserer le nom événement',
                    'class'=>'nomEvenement'
                ]
            ])


            ->add('prenom',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Veuillez inserer le nom de l evenement',
                    'class'=>'prenom'
                ]
            ])
            ->add('sexe',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Veuillez inserer le sexe',
                    'class'=>'sexe'
                ]
            ])
            ->add('statut',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Veuillez inserer le statut',
                    'class'=>'statut'
                ]
            ])
            ->add('mail',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Veuillez inserer le mail',
                    'class'=>'mail'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
