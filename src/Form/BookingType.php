<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class, [
                'attr'=>[
                    'required',
                    'placeholder' => 'mon.courriel@internet.fr'
                ]
            ])
            ->add('entry',TextType::class,[
                'attr' => [
                    'required',
                    'class' => 'datepicker',
                    'placeholder' => 'Sélectionner une date']
            ])
            ->add('period', ChoiceType::class,[
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
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => Booking::class,
        ]);
    }
}
