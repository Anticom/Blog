<?php

namespace Anticom\ShowcaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterType extends AbstractType {
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(
            [
                'data_class'        => 'Anticom\ShowcaseBundle\Entity\User',
                'method'            => 'post',
                'validation_groups' =>
                    [
                        'registration'
                    ]
            ]
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('username', 'text', ['label' => 'Benutzername'])
            ->add('email', 'email', ['label' => 'E-mail'])
            ->add('password', 'password', ['label' => 'Passwort'])
            ->add('password2', 'password', ['label' => 'Passwort wiederholen', 'mapped' => false])
            ->add('submit', 'submit', ['label' => 'Anmelden']);
    }

    public function getName() {
        return 'user_register';
    }
}