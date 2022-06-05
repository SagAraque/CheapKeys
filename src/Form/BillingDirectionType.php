<?php

namespace App\Form;

use App\Entity\Billing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class BillingDirectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('billingName', TextType::class, [
                'label'=>'Nombre y apellidos',
                'label_attr' =>[
                     'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'control__input--full'
                ],
                "empty_data" => "",
                'constraints' => [
                    new NotBlank([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 50
                    ])
                ]
            ])
            ->add('billingDirection', TextType::class, [
                'label' => 'Dirección',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'control__input--full'
                ],
                "empty_data" => "",
                'constraints' => [
                    new NotBlank([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 60
                    ])
                ]
            ])
            ->add('billingPostal', TextType::class, [
                'label'=>'Código postal',
                'label_attr' =>[
                     'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'control__input--full'
                ],
                "empty_data" => "",
                'constraints' => [
                    new NotBlank([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                    new Regex([
                        'message' => 'La fecha es incorrecta',
                        'pattern' => "/^[0-9]{5}+$/i",
                        'htmlPattern' => "^[0-9]{5}"
                    ])
                ]
            ])
            ->add('billingPoblation', TextType::class, [
                'label' => 'Población',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'control__input--full'
                ],
                "empty_data" => "",
                'constraints' => [
                    new NotBlank([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 30
                    ])
                ]
            ])
            ->add('billingCountry', CountryType::class, [
                'label' => 'País',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'control__input--full'
                ],
                "empty_data" => "",
                'constraints' => [
                    new NotBlank([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                ]
            ])
            ->add('billingProvince', TextType::class, [
                'label' => 'Provincia',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'control__input--full'
                ],
                "empty_data" => "",
                'constraints' => [
                    new NotBlank([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 30
                    ])
                ]
            ])
            ->add('billinTlfo', TelType::class, [
                'label' => 'Teléfono',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'control__input--full '
                ],
                "empty_data" => "",
                'constraints' => [
                    new NotBlank([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                    new Length([
                        'min' => 9,
                        'max' => 9
                    ])
                ]
            ]) ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Billing::class,
        ]);
    }
}