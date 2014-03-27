<?php
/**
 * DefaultController.php
 *
 * @author    Timo M
 * @namespace Anticom\ShowcaseBundle\Controller
 * @package   Controller
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Anticom\ShowcaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 */
class DefaultController extends Controller {
    /**
     * Show static launch page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction() {
        return $this->render('AnticomShowcaseBundle:Default:index.html.twig');
    }

    /**
     * Show static impress page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function impressAction() {
        return $this->render('AnticomShowcaseBundle:Default:impress.html.twig');
    }

    /**
     * Show static contact page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction() {
        return $this->render('AnticomShowcaseBundle:Default:contact.html.twig');
    }
}
