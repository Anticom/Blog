<?php
/**
 * CommentType.php
 *
 * @author    Timo M
 * @namespace Anticom\ShowcaseBundle\Form\Type
 * @package   FormType
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Anticom\ShowcaseBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CommentType
 */
class CommentType extends AbstractType {
    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolverInterface $resolver The resolver for the options.
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(
            array(
                'data_class' => 'Anticom\ShowcaseBundle\Entity\Comment',
                'method'     => 'post'
            )
        );
    }

    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting form the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array                $options The options
     */
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

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName() {
        return 'comment_new';
    }
}