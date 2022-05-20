<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('userEmail', EmailType::class, [
            'label' => 'Email',
            'label_attr' =>[
                'class' => 'form__label'
            ],
            'attr' => [
                'class' => 'form__input',
                'name' => 'userEmail'
            ],
            'constraints' => [
                new NotBlank(),
                new Type(EmailType::class)
            ]
        ])
        ->add('password', PasswordType::class, [
            'label' => 'Contraseña',
            'label_attr' =>[
                'class' => 'form__label'
            ],
            'attr' => [
                'class' => 'form__input',
                'name' => 'password'
            ],
            'constraints' => [
                new NotBlank()
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }

}
