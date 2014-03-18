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
            ->add('body', 'text', ['label' => 'Text'])
            ->add('submit', 'submit', ['label' => 'Kommentar abschicken']);
    }

    public function getName() {
        return 'comment_new';
    }
}