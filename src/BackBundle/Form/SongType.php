<?php

namespace BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class SongType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label'=> false,
                'required'  => true,
                'attr' => array(
                    'placeholder'=> "Nom de la chanson"
                )
            ))
            ->add('duration', TextType::class, array(
                'label'=> false,
                'required'  => false,
                'attr' => array(
                    'placeholder'=> "Durée de la chanson min:sec"
                )
            ))
            ->add('file', FileType::class, array(
                "mapped" => false,
                'required'  => true,
                'label'=> false,
                // 'attr'=> array(
                //     'class' => 'd-none',
                //     'onchange' => "readURL(this)",
                // )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackBundle\Entity\Song'
        ));
    }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function getBlockPrefix()
    // {
    //     return 'backbundle_song';
    // }


}
