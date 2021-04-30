<?php

namespace App\Form;

use App\Entity\Cour2;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AjoutcourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('extension',FileType::class,[
                'label' => 'Cour :',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the cour details zeydaaa
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un document PDF valide',
                    ])
                ],
            ])
            ->add('image',FileType::class,[
        'label' => 'Image :',

        // unmapped means that this field is not associated to any entity property
        'mapped' => false,

        // make it optional so you don't have to re-upload the PDF file
        // every time you edit the cour details zeydaaa
        'required' => false,

        // unmapped fields can't define their validation using annotations
        // in the associated entity, so you can use the PHP constraint classes
        'constraints' => [
            new File([
                'mimeTypes' => [
                    "image/jpeg","image/gif","image/png","image/jfif"
                ],
                'mimeTypesMessage' => 'Veuillez télécharger une image .png ,.jpeg , .gif ou jfif'
            ])
        ],
    ])
            ->add('idf',EntityType::class,[
                'class'=>Formation::class,
                'choice_label'=>'sujet',
                'label'=>'Sujet :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cour2::class,
        ]);
    }
}
