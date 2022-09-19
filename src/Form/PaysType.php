<?php

namespace App\Form;

use App\Entity\Age;
use App\Entity\Pays;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('ages', EntityType::class, [
                "class" => Age::class,
                "choice_label" => "nom",
                "mapped" => false,
                "multiple" => true,
                "expanded" => true,
                "required" => false
            ])
            ->add('events')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pays::class,
        ]);
    }
}
