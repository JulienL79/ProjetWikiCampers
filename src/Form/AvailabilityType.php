<?php

namespace App\Form;

use App\Entity\Availability;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class AvailabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDateA', DateType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Début de disponibilité',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('endDateA', DateType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Fin de disponibilité',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('dayPriceA', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Prix journalier en €',
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
                ], 'label' => $options['method'] === 'POST' ? 'Créer' : 'Modifier'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Availability::class,
        ]);
    }
}
