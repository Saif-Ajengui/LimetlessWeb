<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typerec',ChoiceType::class,[
                'choices'=>[
                'coach'=>"coach",
                'paiement'=>"paiement",
                'Rendez_vous'=>"Rendez_vous",
                'Evennement'=>"Evennement",
                'Autre'=>"Autre"
                ]
            ])
            ->add('description')
            ->add('email')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
