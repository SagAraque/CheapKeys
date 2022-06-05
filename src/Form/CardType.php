<?php

namespace App\Form;

use App\Entity\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\CardScheme;
use Symfony\Component\Validator\Constraints\Regex;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cardNumber', IntegerType::class, [
                'label' => 'Número de tarjeta',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'control__input--full control__input--num',
                    'min' => 0
                ],
                "empty_data" => "",
                'constraints' => [
                    new NotBlank(),
                    new CardScheme([
                        'message' => 'El número de tarjeta no es valido',
                        'schemes' => ['VISA', 'MASTERCARD', 'MAESTRO']
                    ])
                ]
            ])
            ->add('cardCvv', IntegerType::class, [
                'label' => 'CVV',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'control__input--full control__input--num',
                    'min' => 0
                ],
                "empty_data" => "",
                'constraints' => [
                    new NotBlank([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 3
                    ])
                ]
            ])
            ->add('cardExpire', TextType::class, [
                'label' => 'Fecha de caducidad',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'control__input--full',
                    'placeholder' => 'mm / yy'
                ],
                "empty_data" => "",
                'constraints' => [
                    new notBlank([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                    new Regex([
                        'message' => 'La fecha es incorrecta',
                        'pattern' => "/^((0[1-9]|1[0-2])\/?([0-9][1-9]|[1-9][0-9])$)/i",
                        'htmlPattern' => "^((0[1-9]|1[0-2])\/?([0-9][1-9]|[1-9][0-9]))"
                    ])
                ]
                
            ])
            ->add('cardName', TextType::class, [
                'label' => 'Titular',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                "empty_data" => "",
                'attr' => [
                    'class' => 'control__input--full'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}