<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Reservation;
use App\Entity\Show;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Firstname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('Lastname', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('tel', TextType::class, [
                'label' => 'Telephone (optionnel)',
                'required' => 'false',

            ])
            ->add('representation', EntityType::class, [
                'class' => Show::class,
                'choice_label' => 'show',
                'label' => 'Representation',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'date-class' => Show::class
        ]);
    }
}
