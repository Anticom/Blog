<?php

namespace Anticom\ShowcaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
    public function indexAction() {
        return $this->render(
            'AnticomShowcaseBundle:Default:index.html.twig'
        );
    }

    public function impressAction() {
        return $this->render(
            'AnticomShowcaseBundle:Default:impress.html.twig'
        );
    }

    public function contactAction() {
        return $this->render(
            'AnticomShowcaseBundle:Default:contact.html.twig'
        );
    }
}
