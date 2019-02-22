<?php

namespace BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use BackBundle\Form\SongType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Valid;

class AlbumType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $artists = $options['artists'];

        $builder
            ->add('artists', EntityType::class, [
                'class' => 'BackBundle:Artist',
                "mapped" => false,
                "multiple"=>true,
                'required'  => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.id', 'DESC');
                },
                'data' => $artists,
                'choice_label' => 'name',
                'attr'=> array(
                    'class' => 'select2',
                )
            ])
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
                    'placeholder'=> "Nom de l'album"
                )
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array(
                    'rows'=> 6,
                    'placeholder'=> "Description de l'album"
                )
            ))
            ->add('producers', TextType::class, array(
                'required'  => false,
                'attr' => array(
                    'placeholder'=> "Producers"
                )
            ))
            ->add('youtubePath', TextType::class, array(
                'required'  => false,
                'attr' => array(
                    'placeholder'=> "Lien Youtube"
                )
            ))
            ->add('amazonPath', TextType::class, array(
                'required'  => false,
                'attr' => array(
                    'placeholder'=> "Lien Amazon"
                )
            ))
            ->add('itunesPath', TextType::class, array(
                'required'  => false,
                'attr' => array(
                    'placeholder'=> "Lien Itunes"
                )
            ))
            ->add('soundCloudPath', TextType::class, array(
                'required'  => false,
                'attr' => array(
                    'placeholder'=> "Lien SoundCloud"
                )
            ))
            ->add('spotifyPath', TextType::class, array(
                'required'  => false,
                'attr' => array(
                    'placeholder'=> "Lien Spotify"
                )
            ))
            ->add('googlePlayPath', TextType::class, array(
                'required'  => false,
                'attr' => array(
                    'placeholder'=> "Lien GooglePlay"
                )
            ))
            ->add('releaseDate', DateTimeType::class ,array(
                'widget'=>'single_text',
                'format' => 'dd/MM/yyyy',
                'attr'=>array(
                    'placeholder'=>'Date de sortie',
                    'class' => 'input-mask',
                    'data-mask' => "00/00/0000",
                )
            ))
            ->add('songs', CollectionType::class, [
                'entry_type' => SongType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackBundle\Entity\Album',
            'artists' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backbundle_album';
    }


}
