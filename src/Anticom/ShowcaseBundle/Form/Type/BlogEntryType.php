<?php

namespace Anticom\ShowcaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlogEntryType extends AbstractType {
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(
            array(
                'data_class' => 'Anticom\ShowcaseBundle\Entity\BlogEntry',
                'method'     => 'post'
            )
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text',
                array(
                    'label' => 'Überschrift',
                    'attr'  => array(
                        'class'       => 'form-control',
                        'placeholder' => 'Überschrift'
                    )
                )
            )
            ->add('body', 'textarea',
                array(
                    'label' => 'Text des Blogeintrages',
                    'attr'  => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add('submit', 'submit',
                array(
                    'label' => 'speichern',
                    'attr'  => array(
                        'class' => 'btn btn-primary'
                    )
                )
            );
    }

    public function getName() {
        return 'blog_entry';
    }
} 