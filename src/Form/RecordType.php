<?php

namespace App\Form;

use App\Entity\MediaType;
use App\Entity\Record;
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
            ->add('name', null, [
                'attr' => [
                    'placeholder' => 'Media\'s name',
                ],
            ])
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
                    'placeholder' => 'Enter a number between 0 and 100'
                ],
            ])
            ->add('remark', null, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Feel free to add a remark... or not !',
                ],
            ])
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
