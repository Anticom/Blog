<?php

namespace Anticom\ShowcaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType {
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(
            [
                'data_class' => 'Anticom\ShowcaseBundle\Entity\Comment',
                'method'     => 'post'
            ]
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add(
                'body',
                'textarea',
                [
                    'label' => 'Ihr kommentar',
                    'attr'  => ['class' => 'form-control']
                ]
            )
            ->add(
                'submit',
                'submit',
                [
                    'label' => 'Kommentar abschicken',
                    'attr'  => ['class' => 'btn btn-primary']
                ]
            );
    }

    public function getName() {
        return 'comment_new';
    }
}