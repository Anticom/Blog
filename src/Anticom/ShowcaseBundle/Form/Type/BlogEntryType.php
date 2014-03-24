<?php

namespace Anticom\ShowcaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlogEntryType extends AbstractType {
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(
            [
                'data_class' => 'Anticom\ShowcaseBundle\Entity\BlogEntry',
                'method'     => 'post'
            ]
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', 'text',
                [
                    'label' => 'Überschrift',
                    'attr'  => [
                        'class'       => 'form-control',
                        'placeholder' => 'Überschrift'
                    ]
                ]
            )
            ->add('body', 'textarea',
                [
                    'label' => 'Text des Blogeintrages',
                    'attr'  => [
                        'class' => 'form-control'
                    ]
                ]
            )
            ->add('submit', 'submit',
                [
                    'label' => 'speichern',
                    'attr'  => [
                        'class' => 'btn btn-primary'
                    ]
                ]
            );
    }

    public function getName() {
        return 'blog_entry';
    }
} 