<?php

namespace Anticom\ShowcaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller {
    public function indexAction() {
        //$this->get('session')->getFlashBag()->add('success', 'Ihr Eintrag wurde gespeichert');

        $blogEntries = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:BlogEntry')->findAll();

        return $this->render(
            'AnticomShowcaseBundle:Blog:index.html.twig',
            [
                'blogEntries'   => $blogEntries
            ]
        );
    }

    public function showAction($id) {
        $blogEntry = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:BlogEntry')->find($id);

        return $this->render(
            'AnticomShowcaseBundle:Blog:show.html.twig',
            [
                'blogEntry'   => $blogEntry
            ]
        );
    }
}