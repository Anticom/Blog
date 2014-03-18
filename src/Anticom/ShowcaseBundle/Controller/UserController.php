<?php

namespace Anticom\ShowcaseBundle\Controller;

use Anticom\ShowcaseBundle\Entity\User;
use Anticom\ShowcaseBundle\Form\Type\LoginType;
use Anticom\ShowcaseBundle\Form\Type\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller {
    public function profileAction() {

    }

    /*
    public function loginAction(Request $request) {
        $user = new User();
        $form = $this->createForm(new LoginType(), $user);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('session')->getFlashBag()->add('success', 'Form is valid!');
            // perform some action, such as saving the task to the database

            return $this->redirect($this->generateUrl('anticom_showcase_index'));
        }

        return $this->render(
            'AnticomShowcaseBundle:User:login.html.twig',
            [
                'form'  => $form->createView()
            ]
        );
    }
    */

    public function registerAction(Request $request) {
        $user = new User();
        $form = $this->createForm(new RegisterType(), $user);

        $form->handleRequest($request);
        if($form->isValid()) {
            $this->get('session')->getFlashBag()->add('success', 'Form is valid!');
        }

        return $this->render(
            'AnticomShowcaseBundle:User:register.html.twig',
            [
                'form'  => $form->createView()
            ]
        );
    }
} 