<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\User;
use App\Entity\Ville;
use App\Repository\PaysRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 20,
                    ]),
                ],
            ])
            ->add("origin" , EntityType::class, [
                "class" => Pays::class,
                "choice_label" => 'nom',
                // "query_builder" => fn (PaysRepository $pr) =>
                //     $pr->
                // ,
                "placeholder" => "Choisissez un pays",
                "required" => false,
                "help" => "choisissez votre pays (optionnel)",
                // "expanded" => true,
                "empty_data" => null,
                "attr" => [
                    "class" => "clique",
                ]
            ])
            ;
            $formModifier = function (FormInterface $form, Pays $pays = null )
            {
                $ville = null === $pays ? [] : $pays->getVilles();
                
                $form->add('ville', EntityType::class, [
                    'class' => Ville::class,
                    'choices' => $ville,
                    'placeholder' => false,
                    "disabled" => $pays === null,
                    'attr' => [
                        'class' => 'apparait cible'
                    ],
                    'label_attr' => [
                        'class' => 'apparait cible'
                    ],
                    
                ]);
            };

            $builder->addEventListener(FormEvents::PRE_SET_DATA, 
            function(FormEvent $event) use ($formModifier) {

                $data = $event->getData();
                $formModifier($event->getForm(), $data->getOrigin());
            });

            $builder->get('origin')->addEventListener(FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                
                
                $origin = $event->getForm()->getData();
                var_dump($origin);die;
                $formModifier($event->getForm()->getParent(), $origin);
            })

            // ->add('ville', EntityType::class, [
            //     'class'=> Ville::class,
            //     "mapped" => false,
            //     "choice_label" => 'nom',
            //     "placeholder" => false,
            //     "required" => false,
            //     "label" => "ville",
            //     "empty_data" => null,
            //     "label_attr" => [
            //         'class' => 'apparait cible'
            //     ],
            //     "attr" => [
            //         "class" => "apparait cible"
            //     ],
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
