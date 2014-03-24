<?php

namespace Anticom\ShowcaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterType extends AbstractType {
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(
            array(
                'data_class'        => 'Anticom\ShowcaseBundle\Entity\User',
                'method'            => 'post',
                'validation_groups' =>
                    array(
                        'registration'
                    )
            )
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('username', 'text', array('label' => 'Benutzername'))
            ->add('email', 'email', array('label' => 'E-mail'))
            ->add('password', 'password', array('label' => 'Passwort'))
            ->add('password2', 'password', array('label' => 'Passwort wiederholen', 'mapped' => false))
            ->add('submit', 'submit', array('label' => 'Anmelden'));
    }

    public function getName() {
        return 'user_register';
    }
}