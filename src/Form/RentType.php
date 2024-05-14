<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class RentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('searchStartDate', DateType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Date de départ',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('searchEndDate', DateType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Date de retour',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('maxPrice', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Prix maximum',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'currency' => false,
                'html5' => true,
                'scale' => 2,
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4',
                ],
                'label' => 'Rechercher'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
