<?php

namespace Anticom\ShowcaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType {
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(
            array(
                'data_class' => 'Anticom\ShowcaseBundle\Entity\Comment',
                'method'     => 'post'
            )
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add(
                'body',
                'textarea',
                array(
                    'label' => 'Ihr kommentar',
                    'attr'  => array('class' => 'form-control')
                )
            )
            ->add(
                'submit',
                'submit',
                array(
                    'label' => 'Kommentar abschicken',
                    'attr'  => array('class' => 'btn btn-primary')
                )
            );
    }

    public function getName() {
        return 'comment_new';
    }
}