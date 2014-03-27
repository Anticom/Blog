<?php
/**
 * UserController.php
 *
 * @author    Timo M
 * @namespace Anticom\ShowcaseBundle\Controller
 * @package   Controller
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Anticom\ShowcaseBundle\Controller;

use Anticom\ShowcaseBundle\Entity\User;
use Anticom\ShowcaseBundle\Form\Type\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 */
class UserController extends Controller {
    /**
     * Show profile for a given User
     *
     * @param int|null $id If null, own profile will be shown
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * Sign up a new User
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
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
            array(
                'form'  => $form->createView()
            )
        );
    }
} 