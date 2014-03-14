<?php

namespace Anticom\ShowcaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
    public function indexAction() {
        return $this->render(
            'AnticomShowcaseBundle:Default:index.html.twig'
        );
    }
}
