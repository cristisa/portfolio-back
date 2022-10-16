<?php

namespace App\Form;

use App\Entity\Proyectos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\FileType;
use Symfony\Component\Form\Extension\Core\Type\FileType as TypeFileType;
use Symfony\Component\Validator\Constraints\Image;

class ProyectosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
            ->add('repositorio')
            ->add('imagen')
            // ->add('imagen', FileType::class, [
            //     'label' => 'Selecciona una imagen', 
            //     'mapped' => false, 
            //     'required' => false,
            //     'constraints' => [
            //         new Image([
            //             'maxSize' => '5k'
            //         ])
            //     ]
            // ])
                
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Proyectos::class,
        ]);
    }
}
