<?php
/**
 * MenuBuilder.php
 *
 * @author    Timo M
 * @namespace Anticom\ShowcaseBundle\Menu
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Anticom\ShowcaseBundle\Menu;

use Anticom\ShowcaseBundle\Entity\User;
use Knp\Menu\FactoryInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class MenuBuilder
 */
class MenuBuilder extends ContainerAware {
    /**
     * Navbar top left menu
     *
     * @param FactoryInterface $factory
     * @param array            $options
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $menu->addChild('Startseite', array('route' => 'index'));
        $menu->addChild('Blog', array('route' => 'anticom_showcase_blog_list'));

        $menu->setCurrentUri($this->container->get('request')->getRequestUri());
        return $menu;
    }

    /**
     * Navbar top right menu
     *
     * @param FactoryInterface $factory
     * @param array            $options
     * @return \Knp\Menu\ItemInterface
     */
    public function userMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

        $user = $this->getUser();
        if($user) {
            $markup = $this->getUserInfo($user);
            $menu->addChild($markup,
                array(
                    'attributes' => array('class' => 'navbar-text'),
                    'label'      => $markup,
                    'extras'     => array('safe_label' => true)
                )
            );
        } else {
            $menu->addChild('Anmelden', array('route' => 'login'));
            //$menu->addChild('Registrieren', array('route' => 'anticom_showcase_register'));
        }

        $menu->setCurrentUri($this->container->get('request')->getRequestUri());
        return $menu;
    }

    /**
     * Auxiliary to get the User if logged in
     *
     * @return User|null
     */
    protected function getUser() {
        /** @var SecurityContextInterface $securityContext */
        $securityContext = $this->container->get('security.context');
        if($securityContext->isGranted(array('ROLE_USER'))) {
            return $securityContext->getToken()->getUser();
        } else {
            return null;
        }
    }

    /**
     * Auxiliary to render User information when logged in
     *
     * @param $user
     * @return string
     */
    protected function getUserInfo($user) {
        /** @var TwigEngine $engine */
        $engine = $this->container->get('templating');
        $markup = $engine->render(
            'AnticomShowcaseBundle:Menu:logged_in.html.twig',
            array(
                'user' => $user
            )
        );
        return $markup;
    }
}