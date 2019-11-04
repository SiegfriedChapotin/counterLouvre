<?php

namespace App\Form;

use App\Entity\Booking;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', RepeatedType::class, [

                'type' => EmailType::class,
                'invalid_message' => 'Vos courriels ne sont pas identiques.',
                'required' => true,
                'first_options' => [
                    'label' => 'Votre courriel',
                    'attr' => [
                        'placeholder' => 'mon.courriel@internet.fr',
                    ],
                ],
                'second_options' => [
                    'label' => 'confimer votre courriel',
                    'attr' => [
                        'placeholder' => 'mon.courriel@internet.fr',
                    ],
                ],
            ])
            ->add('entry', DateType::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'required' => true,
                'attr' => [
                    'class' => 'datepicker',
                    'placeholder' => 'Sélectionner une date']
            ])
            ->add('period', ChoiceType::class, [
                'attr' => [
                    'required'
                ],
                'choices' => [
                    'Journée complète' => '1',
                    'Demi-journée' => '0']
            ])
            ->add('numberTicket', IntegerType::class, [
                'attr' => [
                    'required',
                    'max' => '6',
                    'min' => '1',
                    'value' => '1'],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => Booking::class,
        ]);
    }
}
