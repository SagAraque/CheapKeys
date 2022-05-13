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
use Symfony\Component\Validator\Constraints\Type;

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
                'constraints' => [
                    new NotBlank()
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
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('userPass', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Las contraseñas deben coincidir',
                'label' => 'Contraseña',
                'label_attr' =>[
                    'class' => 'form__label'
                ],
                'options' => [
                    'attr' => [
                       'class' => 'form__input', 
                    ]
                ],
                'first_options'  => ['label' => 'Contraseña', 'label_attr' =>['class' => 'form__label'],],
                'second_options' => ['label' => 'Repetir contraseña', 'label_attr' =>['class' => 'form__label'],],
                'constraints' => [
                    new NotBlank()
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
