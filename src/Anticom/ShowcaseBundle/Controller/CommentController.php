<?php
/**
 * CommentController.php
 *
 * @author    Timo M
 * @namespace Anticom\ShowcaseBundle\Controller
 * @package   Controller
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Anticom\ShowcaseBundle\Controller;

use Anticom\ShowcaseBundle\Entity\BlogEntry;
use Anticom\ShowcaseBundle\Entity\Comment;
use Anticom\ShowcaseBundle\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class CommentController
 */
class CommentController extends Controller {
    /**
     * Create a new Comment
     *
     * @param Request   $request
     * @param BlogEntry $blogEntry
     * @param null      $parentComment
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function newAction(Request $request, BlogEntry $blogEntry, $parentComment = null) {
        if(!$this->getUser()) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $rootComment = null;
        if($parentComment != null) {
            /** @var Comment $parentComment */
            $parentComment = $em->getRepository('AnticomShowcaseBundle:Comment')->find($parentComment);
            if(!$blogEntry) throw $this->createNotFoundException('Der Kommentar zum Blogeintrag konnte nicht gefunden werden!');

            $rootComment = $parentComment->getRootComment();
        }

        $comment = new Comment();
        $comment->setAuthor($this->getUser())
            ->setBlogEntry($blogEntry)
            ->setParent($parentComment);
        $form = $this->createForm(new CommentType(), $comment);

        $form->handleRequest($request);
        if($form->isValid()) {
            $em->persist($comment);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Ihr Kommentar wurde erfolgreich gespeichert!');
            return $this->redirect($this->generateUrl('anticom_showcase_blog_show', array('id' => $blogEntry->getId())));
        }

        return $this->render(
            'AnticomShowcaseBundle:Comment:new.html.twig',
            array(
                'form'          => $form->createView(),
                'blogEntry'     => $blogEntry,
                'parentComment' => $parentComment,
                'rootComment'   => $rootComment
            )
        );
    }
}