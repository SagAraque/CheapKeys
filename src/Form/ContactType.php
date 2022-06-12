<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Nombre',
            'label_attr' => [
                'class' => 'contact__label'
            ],
            'attr' => [
                'class' => 'contact__input',
            ],
            "empty_data" => "",
            'constraints' => [
                new NotBlank([
                    'message' => 'El campo no puede estar vacio'
                ]),
                new NotNull([
                    'message' => 'El campo no puede estar vacio'
                ]),
                new Regex([
                    'message' => 'El nombre no tiene un formato correcto',
                    'pattern' => "/^[a-z A-Z À-ÿ ñ]+$/i",
                    'htmlPattern' => "^[a-z A-Z À-ÿ ñ]"
                ])
            ]
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'label_attr' => [
                'class' => 'contact__label'
            ],
            'attr' => [
                'class' => 'contact__input',
            ],
            "empty_data" => "",
            'constraints' => [
                new notBlank([
                    'message' => 'El campo no puede estar vacio'
                ]),
                new NotNull([
                    'message' => 'El campo no puede estar vacio'
                ]),
                new Email([
                    'message' => 'El email no es válido'
                ])
            ]
        ])
        ->add('message', TextareaType::class, [
            'label' => 'Mensaje',
            'label_attr' => [
                'class' => 'contact__label'
            ],
            'attr' => [
                'class' => 'contact__textarea',
            ],
            "empty_data" => "",
            'constraints' => [
                new notBlank([
                    'message' => 'El campo no puede estar vacio'
                ]),
                new NotNull([
                    'message' => 'El campo no puede estar vacio'
                ]),
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
