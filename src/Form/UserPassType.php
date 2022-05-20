<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserPassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('newPass', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Las contraseñas deben coincidir',
            'label' => 'Contraseña',
            'label_attr' =>[
                'class' => 'control__label'
            ],
            'options' => [
                'attr' => [
                   'class' => 'control__input', 
                ]
            ],
            'first_options'  => ['label' => 'Nueva contraseña', 'label_attr' =>['class' => 'control__label'],],
            'second_options' => ['label' => 'Repetir contraseña', 'label_attr' =>['class' => 'control__label'],],
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 6, 'max' => 16])
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
