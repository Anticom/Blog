<?php

namespace Anticom\ShowcaseBundle\Controller;

use Anticom\ShowcaseBundle\Entity\User;
use Anticom\ShowcaseBundle\Form\Type\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller {
    public function profileAction($id = null) {
        if($id === null) {
            $user = $this->getUser();
        } else {
            $user = $this->getDoctrine()->getManager()->getRepository('AnticomShowcaseBundle:User')->find($id);
        }

        return $this->render(
            'AnticomShowcaseBundle:User:profile.html.twig',
            array(
                'user'  => $user
            )
        );
    }

    public function registerAction(Request $request) {
        $user = new User();
        $form = $this->createForm(new RegisterType(), $user);

        $form->handleRequest($request);
        if($form->isValid()) {
            $this->get('session')->getFlashBag()->add('success', 'Form is valid!');
        }

        return $this->render(
            'AnticomShowcaseBundle:User:register.html.twig',
            array(
                'form'  => $form->createView()
            )
        );
    }
} 