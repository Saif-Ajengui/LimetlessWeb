<?php

namespace App\Form;

use App\Entity\Evenement;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\VarDumper\Caster\DateCaster;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Veuillez inserer le nom',
                    'class'=>'nom'
                ]
            ])
            ->add('description',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Veuillez inserer la description',
                    'class'=>'description'
                ]
            ])
            ->add('type',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Veuillez inserer le type',
                    'class'=>'type'
                ]
            ])
            ->add('dateDeb')
            ->add('dateFin')
            ->add('nbMaxParticipant')




        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
