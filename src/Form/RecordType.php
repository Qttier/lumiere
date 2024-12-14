<?php

namespace App\Form;

use App\Entity\MediaType;
use App\Entity\Record;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class RecordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('rate', IntegerType::class, [
                'constraints' => [
                    new Range([
                        'min' => 0,
                        'max' => 100,
                        'notInRangeMessage' => 'Rate must be between {{ min }} and {{ max }}.',
                    ]),
                ],
                'attr' => [
                    'min' => 0,
                    'max' => 100,
                    'class' => 'form-control',
                ],
            ])
            ->add('remark')
            ->add('type', EntityType::class, [
                'class' => MediaType::class,
                'choice_label' => 'type',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Record::class,
        ]);
    }
}
