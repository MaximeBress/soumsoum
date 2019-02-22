<?php

namespace BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArtistType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class, array(
                'attr' => array(
                    'rows'=> 6
                )
            ))
            ->add('image', FileType::class, array(
                "mapped" => false,
                'required'  => false,
                'label'=> false,
                'attr'=> array(
                    'class' => 'd-none',
                    'onchange' => "readURL(this)",
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
            ->add('instaPath', TextType::class, array(
                'required'  => false,
                'attr' => array(
                    'placeholder'=> "Lien Instagram"
                )
            ))
            ->add('spotifyPath', TextType::class, array(
                'required'  => false,
                'attr' => array(
                    'placeholder'=> "Lien Spotify"
                )
            ))
            // ->add('albums');
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackBundle\Entity\Artist'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backbundle_artist';
    }


}
