<?php
/**
 * MenuBuilder.php
 *
 * Date: 17.03.14
 * Time: 13:41
 * @author    Timo Mühlbach
 * @namespace Anticom\ShowcaseBundle\Menu
 */

namespace Anticom\ShowcaseBundle\Menu;

use Anticom\ShowcaseBundle\Entity\User;
use Knp\Menu\FactoryInterface;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\SecurityContextInterface;

class MenuBuilder extends ContainerAware {
    public function mainMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $menu->addChild('Startseite', ['route' => 'index']);
        $menu->addChild('Blog', ['route' => 'anticom_showcase_blog_list']);

        $menu->setCurrentUri($this->container->get('request')->getRequestUri());
        return $menu;
    }

    public function userMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

        $user = $this->getUser();
        if($user) {
            $markup = $this->getUserInfo($user);
            $menu->addChild($markup,
                [
                    'attributes' => ['class' => 'navbar-text'],
                    'label'      => $markup,
                    'extras'     => ['safe_label' => true]
                ]
            );
        } else {
            $menu->addChild('Anmelden', ['route' => 'login']);
            $menu->addChild('Registrieren', ['route' => 'anticom_showcase_register']);
        }

        $menu->setCurrentUri($this->container->get('request')->getRequestUri());
        return $menu;
    }

    protected function getUser() {
        /** @var SecurityContextInterface $securityContext */
        $securityContext = $this->container->get('security.context');
        if($securityContext->isGranted(['ROLE_USER'])) {
            /** @var User $user */
            return $securityContext->getToken()->getUser();
        } else {
            return null;
        }
    }

    protected function getUserInfo($user) {
        /** @var TwigEngine $engine */
        $engine = $this->container->get('templating');
        $markup = $engine->render(
            'AnticomShowcaseBundle:Menu:logged_in.html.twig',
            [
                'user' => $user
            ]
        );
        return $markup;
    }
}