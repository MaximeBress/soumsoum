<?php

namespace BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, array(
                "mapped" => false,
                'required'  => false,
                'label'=> false,
                'attr'=> array(
                    'class' => 'd-none',
                    'onchange' => "readURL(this)",
                )
            ))
            ->add('name', TextType::class, array(
                'attr' => array(
                    'placeholder'=> "Nom de l'event"
                )
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array(
                    'rows'=> 6,
                    'placeholder'=> "Description de l'event"
                )
            ))
            ->add('startAt', DateTimeType::class ,array(
                'widget'=>'single_text',
                'format' => 'dd/MM/yyyy HH:ii',
                'attr'=>array(
                    'placeholder'=>'Date de sortie',
                    'class' => 'input-mask',
                    'data-mask' => "00/00/0000",
                )
            ))
            ->add('location', TextType::class, array(
                'attr' => array(
                    'placeholder'=> "Lieu de l'event"
                )
            ))
            ->add('youtubePath', TextType::class, array(
                'required'  => false,
                'attr' => array(
                    'placeholder'=> "Lien Youtube"
                )
            ))
            ->add('facebookPath', TextType::class, array(
                'required'  => false,
                'attr' => array(
                    'placeholder'=> "Lien Facebook"
                )
            ))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backbundle_event';
    }


}
