<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstructeurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'Email:'])
            ->add('username', TextType::class, ['label' => 'Gebruikersnaam:'])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Wachtwoord:'),
                'second_options' => array('label' => 'Herhaal wachtwoord:'),
            ))
            ->add("firstname", TextType::class, ['label' => 'Voornaam:'])
            ->add("preprovision", TextType::class, ['required' => false, 'label' => 'Tussenvoegsel:'])
            ->add("lastname", TextType::class, ['label' => 'Achternaam:'])
            ->add("dateofbirth", BirthdayType::class, ['label' => 'Geboortedatum:', 'format' => 'dd-MM-yyyy',])
            ->add("gender", ChoiceType::class, ['label' => 'Gender:',
                'choices' => [
                    'Male' => "Man",
                    'Female' => "Vrouw",
                ]])
            ->add("hire_date", DateType::class, ['label' => 'Huurdatum', 'format' => 'dd-MM-yyyy'])
            ->add("salary", MoneyType::class, ['label' => 'Salaris'])
            ;

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Instructeur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
