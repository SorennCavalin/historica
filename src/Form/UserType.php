<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\User;
use App\Form\TestType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('age')
            ->add('origin', EntityType::class, [
                "class" => Pays::class,
                "choice_label" => 'nom',
                "expanded" => true
            ])
            ->add('roles' , ChoiceType::class , [
                'choices' => [
                    "Administrateur" => "ROLE_ADMIN",
                    "Utilisateur" => "ROLE_USER",
                ],
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
