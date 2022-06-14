<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userName', TextType::class, [
                'label' => 'Nombre de usuario',
                'label_attr' => [
                    'class' => 'form__label'
                ],
                'attr' => [
                    'class' => 'form__input',
                ],
                "empty_data" => "",
                'constraints' => [
                    new NotBlank([
                        'message' => 'El usuario no puede estar vacio'
                    ])
                ]
            ])
            ->add('userEmail', EmailType::class, [
                'label' => 'Email',
                'label_attr' =>[
                    'class' => 'form__label'
                ],
                'attr' => [
                    'class' => 'form__input',
                ],
                "empty_data" => "",
                'constraints' => [
                    new NotBlank([
                        'message' => 'El email no puede estar vacio'
                    ]),
                ]
            ])
            ->add('userPass', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Las contraseñas deben coincidir',
                'label' => 'Contraseña',
                'label_attr' =>[
                    'class' => 'form__label'
                ],
                "empty_data" => "",
                'options' => [
                    'attr' => [
                       'class' => 'form__input', 
                    ]
                ],
                'first_options'  => ['label' => 'Contraseña', 'label_attr' =>['class' => 'form__label'],],
                'second_options' => ['label' => 'Repetir contraseña', 'label_attr' =>['class' => 'form__label'],],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Se requiere una contraseña'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
            'constraints' => [
                new UniqueEntity([
                    'message' => 'El email ya está en uso',
                    'entityClass' => Users::class,
                    'fields' => 'userEmail',
                ]),
                new UniqueEntity([
                    'message' => 'El nombre de usuario ya está en uso',
                    'entityClass' => Users::class,
                    'fields' => 'userName',
                ]),
            ],
        ]);
    }
}
