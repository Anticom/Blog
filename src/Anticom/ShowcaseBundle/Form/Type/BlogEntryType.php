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
            ->add('title', 'text', ['label' => 'Überschrift'])
            ->add('body', 'text', ['label' => 'Text'])
            ->add('submit', 'submit', ['label' => 'speichern']);
    }

    public function getName() {
        return 'blog_entry';
    }
} 