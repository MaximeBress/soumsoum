<?php
// your-path-to-types/ContactType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('attr' => array('placeholder' => 'Nom', 'class' => 'form-control'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez fournir votre nom")),
                )
            ))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Email', 'class' => 'form-control'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez fournir une adresse email")),
                    new Email(array("message" => "Votre email ne semble pas valide")),
                )
            ))
            ->add('message', TextareaType::class, array('attr' => array('placeholder' => 'Message', 'class' => 'form-control', 'rows' => '3'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez écrire votre message içi")),
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_bubbling' => true
        ));
    }

    public function getName()
    {
        return 'contact_form';
    }
}
