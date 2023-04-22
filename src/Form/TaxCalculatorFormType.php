<?php

namespace App\Form;

use App\Entity\Product;
use App\Form\Model\TaxCalculatorFormModel;
use App\Form\Validator\Constraint\TaxNumberIsValid;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxCalculatorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'product',
                EntityType::class,
                [
                    'class' => Product::class,
                    'choice_label' => static fn(Product $product) => sprintf(
                        '%s - EUR %.2f',
                        $product->getName(),
                        $product->getPrice()
                    ),
                    'placeholder' => 'Choose a product',
                ]
            )
            ->add(
                'taxNumber',
                TextType::class,
                [
                    'attr' => [
                        'placeholder' => 'Enter your Tax number',
                    ],
                    'constraints' => [
                        new TaxNumberIsValid(),
                    ]
                ]

            )
            ->add(
                'calculate',
                SubmitType::class,
                [
                    'label' => 'Calculate',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TaxCalculatorFormModel::class,
            'method' => 'get'
        ]);
    }
}
