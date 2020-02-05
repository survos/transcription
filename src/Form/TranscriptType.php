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
        /** @var Transcript $transcript */
        $transcript = $options['data'];
        $builder
            ->add('code')
            ->add('name')
            ->add('text', TextareaType::class, [
                'attr' => [
                    'rows' => count(explode("\n", $transcript->getText()))+2,
                ]
            ])
            ->add('filename')
            ->add('attempt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transcript::class,
        ]);
    }
}
