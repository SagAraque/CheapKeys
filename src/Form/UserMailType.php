<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotNull;

class UserMailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('userEmail', EmailType::class, [
            'label' => 'Email',
            'label_attr' =>[
                'class' => 'control__label'
            ],
            'attr' => [
                'class' => 'control__input',
            ],
            "empty_data" => "",
            'constraints' => [
                new NotBlank([
                    'message' => 'El email no puede estar vacio'
                ]),
                
                new NotNull([
                    'message' => 'El email no puede estar vacio'
                ])
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
