<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class AdminUsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userName', TextType::class, [
                'label' => 'Nombre de usuario',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'admin__input'
                ],
                 'empty_data' => '',
                 'constraints' => [
                    new NotBlank([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                    new NotNull([
                        'message' => 'El campo no puede ser nullo'
                    ])
                 ]
            ])
            ->add('userEmail', EmailType::class, [
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'admin__input'
                ],
                 'empty_data' => '',
                 'constraints' => [
                    new NotBlank([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                    new NotNull([
                        'message' => 'El campo no puede ser nullo'
                    ]),
                    new Email([
                        'message' => 'Debe introducir un usuario valido'
                    ])
                 ]
            ])
            ->add('userPass', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Las contraseñas deben coincidir',
                'label' => 'Contraseña',
                'label_attr' =>[
                    'class' => 'control__label',
                    'name' => 'newPass'
                ],
                "empty_data" => "",
                'options' => [
                    'attr' => [
                       'class' => 'admin__input', 
                    ]
                ],
                'required' => false,
                'mapped'=>false,
                'first_options'  => ['label' => 'Nueva contraseña', 'label_attr' =>['class' => 'control__label'],],
                'second_options' => ['label' => 'Repetir contraseña', 'label_attr' =>['class' => 'control__label'],],
                'constraints' => [
                    new Length(['min' => 6, 'max' => 16])
                ]
            ])
            ->add('userRol', ChoiceType::class, [
                'label' => 'Rol',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'admin__input'
                ],
                 'empty_data' => '',
                 'choices' => [
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN'
                 ]
            ])
            ->add('userState', ChoiceType::class, [
                'label' => 'Estado',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'admin__input'
                ],
                 'empty_data' => '',
                 'choices' => [
                    'ACTIVE' => 'ACTIVE',
                    'DELETED' => 'DELETED'
                 ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
