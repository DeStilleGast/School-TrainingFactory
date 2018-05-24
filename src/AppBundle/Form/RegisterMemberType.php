<?php
/**
 * Created by PhpStorm.
 * User: Falco
 * Date: 22-5-2018
 * Time: 14:52
 */

namespace AppBundle\Form;


use AppBundle\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterMemberType extends AbstractType
{
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
            ->add("Street", TextType::class, ['label' => 'Straat:'])
            ->add("portal_code", TextType::class, ['label' => 'Postcode:'])
            ->add("place", TextType::class, ['label' => 'Stad/drop:'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Member']);
    }


}