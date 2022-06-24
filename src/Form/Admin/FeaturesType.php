<?php

namespace App\Form;

use App\Entity\Features;
use Doctrine\Inflector\Rules\Pattern;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\Range;

class FeaturesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gameName', TextType::class, [
                'label' => 'Nombre del producto',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'admin__input'
                ],
                'data' => $options['game'],
                'empty_data' => '',
                'mapped'=>false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                    new NotNull([
                        'message' => 'El campo no puede ser nullo'
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 150,
                        'minMessage' => 'El nombre debe contener entre 10 y 150 caracteres',
                        'maxMessage' => 'El nombre debe contener entre 10 y 150 caracteres'
                    ])
                ]
            ])
            ->add('gamePlatform', EntityType::class, [
                'label' => 'Plataforma',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'admin__input'
                ],
                'empty_data' => '',
                'mapped'=>false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.platformName', 'ASC');
                },
                'choice_label' => 'platformName',
                'class' => 'App\Entity\Platforms',
                'data' => $options['platform']
                
            ])
            ->add('gameDesc', TextareaType::class, [
                'label' => 'Descripción',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'admin__textArea'
                ],
                'empty_data' => '',
                'constraints' => [
                    new NotBlank([
                        'message' => 'El campo no puede estar vacio'
                    ]),
                    new NotNull([
                        'message' => 'El campo no puede ser nullo'
                    ]),
                    new Length([
                        'min' => 150,
                        'minMessage' => 'La descripción debe ser mayor a 150 caracteres',
                    ])
                ]
            ])
            ->add('gameDeveloper', TextType::class, [
                'label' => 'Desarrollador',
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
                    new Length([
                        'min' => 2,
                        'max' => 100,
                        'minMessage' => 'El desarrollador debe contener entre 10 y 150 caracteres',
                        'maxMessage' => 'El desarrollador debe contener entre 10 y 150 caracteres'
                    ])
                ]
            ])
            ->add('gameDistributor', TextType::class, [
                'label' => 'Distribuidor',
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
                    new Length([
                        'min' => 2,
                        'max' => 150,
                        'minMessage' => 'El distribuidor debe contener entre 10 y 150 caracteres',
                        'maxMessage' => 'El distribuidor debe contener entre 10 y 150 caracteres'
                    ])
                ]
            ])
            ->add('gameDate', DateType::class,[
                'label' => 'Fecha de lanzamiento',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'admin__input--date'
                ],
                'widget' => 'single_text',
                'html5' => true,
                'format' => 'yyyy-MM-dd',
            ])
            ->add('gamePrice', NumberType::class,[
                'label' => 'Precio',
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
                ]
            ])
            ->add('gamePegi', ChoiceType::class, [
                'label' => 'Pegi',
                'label_attr' => [
                    'class' => 'control__label'
                ],
                'attr' => [
                    'class' => 'admin__input'
                ],
                 'empty_data' => '',
                 'choices' => [
                    '3' => '3',
                    '6' => '6',
                    '12' => '12',
                    '16' => '16',
                    '18' => '18',
                 ]
            ]);

            if($options['images']){
                $builder->add('gameImages', FileType::class, [
                    'label' => 'Imágenes',
                    'label_attr' => [
                        'class' => 'control__label'
                    ],
                    'attr' => [
                        'class' => 'admin__input--image',
                        'name' => 'gameImages',
                    ],
                     'empty_data' => '',
                     'mapped'=>false,
                    'multiple' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'El campo no puede estar vacio'
                        ]),
                        new NotNull([
                            'message' => 'El campo no puede ser nullo'
                        ]),
                        new File([
                            'maxSize' => "10M",
                            'mimeTypes' => [
                                "image/jpeg",
                                "image/jpg",
                                "image/png",
                                "image/webp",
                            ],
                        ])
                    ]
                ])
                ->add('gameMainImage', FileType::class, [
                    'label' => 'Imagen principal',
                    'label_attr' => [
                        'class' => 'control__label'
                    ],
                    'attr' => [
                        'class' => 'admin__input--image',
                        'name' => 'gameMainImage',
                    ],
                     'empty_data' => '',
                     'mapped'=>false,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'El campo no puede estar vacio'
                        ]),
                        new NotNull([
                            'message' => 'El campo no puede ser nullo'
                        ]),
                        new File([
                            'maxSize' => "10M",
                            'mimeTypes' => [
                                "image/jpeg",
                                "image/jpg",
                                "image/png",
                                "image/webp",
                            ],
                        ])
                    ]
                ])
                ->add('gameInfoImage', FileType::class, [
                    'label' => 'Imagen banner',
                    'label_attr' => [
                        'class' => 'control__label'
                    ],
                    'attr' => [
                        'class' => 'admin__input--image',
                        'name' => 'gameInfoImage',
                    ],
                     'empty_data' => '',
                     'mapped'=>false,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'El campo no puede estar vacio'
                        ]),
                        new NotNull([
                            'message' => 'El campo no puede ser nullo'
                        ]),
                        new File([
                            'maxSize' => "10M",
                            'mimeTypes' => [
                                "image/jpeg",
                                "image/jpg",
                                "image/png",
                                "image/webp",
                            ],
                        ])
                    ]
                ]);
            }

            if($options['modify']){
                $builder->add('gameDiscount', NumberType::class,[
                        'label' => 'Descuento',
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
                            new Range([
                                'min' => 0,
                                'max' => 100,
                                'notInRangeMessage' => 'El descuento debe estar entre el 0 y el 100%'
                            ])
                        ]
                    ])
                    ->add('gameState',ChoiceType::class, [
                        'label' => 'Estado',
                        'label_attr' => [
                            'class' => 'control__label'
                        ],
                        'attr' => [
                            'class' => 'admin__input'
                        ],
                         'empty_data' => '',
                         'mapped'=>false,
                         'data' => $options['state'],
                         'choices' => [
                            'Desactivado' => false,
                            'Activado' => true,
                         ]
                    ]);
            }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Features::class,
            'game' => '',
            'images' => 1,
            'modify' => 0,
            'state' => false,
            'platform' => null
        ]);
    }
}
