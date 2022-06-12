<?php

namespace App\Form;

use App\Entity\Reviews;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class ReviewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reviewCalification', NumberType::class, [
                'label' => 'Calificación',
                'label_attr' => [
                    'class' => 'reviews__label'
                ],
                'attr' => [
                    'class' => 'reviews__input--cal',
                    'min' => 0,
                    'max' => 10,
                    'step' => 0.1,
                    'pattern' => '^([0-9]|10|[0-9].[0-9]|10.0)$',
                    'autofocus' => 'autofocus',
                    'placeholder' => '0.0'
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
                        'message' => 'La calificación es incorrecta',
                        'pattern' => "/^([0-9]|10|[0-9].[0-9]|10.0)$/i",
                        'htmlPattern' => "^[1][0]\.[0]|[0-9]\.[0-9]{1}"
                    ])
                ]
            ])
            ->add('reviewDesc', TextareaType::class, [
                'label' => 'Reseña',
                'label_attr' => [
                    'class' => 'reviews__label'
                ],
                'attr' => [
                    'class' => 'reviews__input',
                    'maxlength' => 255
                ],
                "empty_data" => "",
                'constraints' => [
                    new NotBlank([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                    new NotNull([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 250,
                        'minMessage' => 'La review debe contener entre 10 - 255 caracteres',
                        'maxMessage' => 'La review debe contener entre 10 - 255 caracteres',
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reviews::class,
            'constraints' => [
                new UniqueEntity([
                    'message' => 'Ya has realizado una reseña del producto',
                    'entityClass' => Reviews::class,
                    'fields' => ['idGame', 'idUser', 'idPlatform'],
                ]),
            ],
        ]);
    }
}
