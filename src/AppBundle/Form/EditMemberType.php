<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditMemberType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'Email:'])
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
            ->add("place", TextType::class, ['label' => 'Stad/dorp:']);

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Member'
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
