<?php

namespace App\Form;

use App\Entity\Transcript;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranscriptType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('attempt', TextareaType::class, ['attr' => ['rows' => 10, 'cols' => 60]])
            ->add('text', TextareaType::class, ['disabled' => false, 'attr' => ['rows' => 10, 'cols' => 60]])
            ->add('code')
            ->add('name')
            ->add('filename')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transcript::class,
        ]);
    }
}
