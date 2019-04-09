<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'label' => 'Nom',
                    'required',
                    'placeholder' => 'Nom']
            ])
            ->add('firstname', TextType::class, [

                'label' => 'Prénom',
                'attr' => [
                    'required',
                    'placeholder' => 'Prénom']
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => 'Date de naissance',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ]
            ])
            ->add('nationality', CountryType::class, [
                'label' => 'Nationalité',
            ])
            ->add('reduced', ChoiceType::class, [
                'label' => 'Réduction',
                'attr' => [
                    'required'
                ],
                'choices' => [
                    'Aucune' => '1',
                    'Adhérents' => '0',
                    'Personnels' => '0',
                    'Guides et conférenciers' => '0',
                    'Bénéficiaires des minima sociaux' => '0',
                    'Demandeurs d\'emploi' => '0',
                    'Pass éducation' => '0',
                    'Étudiant' => '0'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
