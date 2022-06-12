<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class UserNameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('userName', TextType::class, [
            'label' => 'Nombre de usuario',
            'label_attr' =>[
                'class' => 'control__label'
            ],
            'attr' => [
                'class' => 'control__input',
            ],
            'empty_data' => "",
            'constraints' => [
                new NotBlank([
                    'message' => 'El usuario  no puede estar vacio'
                ]),
                new NotNull([
                    'message' => 'El usuario no puede estar vacio'
                ]),
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
            'constraints' => [
                new UniqueEntity([
                    'message' => 'El nombre de usuario ya está en uso',
                    'entityClass' => Users::class,
                    'fields' => 'userName',
                ]),
            ],
        ]);
    }

}
