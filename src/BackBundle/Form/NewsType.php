<?php

namespace BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Valid;

class NewsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $type = $options['category'];

        $builder
            ->add('newsType', EntityType::class, [
                'class' => 'BackBundle:NewsType',
                "mapped" => false,
                'required'  => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.id', 'DESC');
                },
                'data' => $type,
                'choice_label' => 'title',
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
            ->add('title', TextType::class, array(
                'attr' => array(
                    'placeholder'=> "Nom de l'article"
                )
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array(
                    'rows'=> 6,
                    'placeholder'=> "Description de l'article"
                )
            ))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackBundle\Entity\News',
            'category' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backbundle_news';
    }


}
