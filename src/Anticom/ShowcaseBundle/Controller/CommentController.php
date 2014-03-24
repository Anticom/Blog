<?php
/**
 * CommentController.php
 *
 * Date: 20.03.14
 * Time: 15:01
 * @author    Timo Mühlbach
 * @namespace Anticom\ShowcaseBundle\Controller
 */

namespace Anticom\ShowcaseBundle\Controller;

use Anticom\ShowcaseBundle\Entity\BlogEntry;
use Anticom\ShowcaseBundle\Entity\Comment;
use Anticom\ShowcaseBundle\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CommentController extends Controller {
    public function newAction(Request $request, $blogEntry, $parentComment = null) {
        if(!$this->getUser()) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        /** @var BlogEntry|null $blogEntry */
        $blogEntry = $em->getRepository('AnticomShowcaseBundle:BlogEntry')->find($blogEntry);
        if(!$blogEntry) throw $this->createNotFoundException('Der Blogeintrag konnte nicht gefunden werden!');

        $rootComment = null;
        if($parentComment != null) {
            /** @var Comment|null $parentComment */
            $parentComment = $em->getRepository('AnticomShowcaseBundle:Comment')->find($parentComment);
            if(!$parentComment) throw $this->createNotFoundException('Der Kommentar zum Blogeintrag konnte nicht gefunden werden!');

            $rootComment = $parentComment->getRootComment();
        }

        $comment = new Comment();
        $comment->setAuthor($this->getUser());
        $comment->setBlogEntry($blogEntry);
        $comment->setParent($parentComment);
        $form = $this->createForm(new CommentType(), $comment);

        $form->handleRequest($request);
        if($form->isValid()) {
            $em->persist($comment);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Ihr Kommentar wurde erfolgreich gespeichert!');
            return $this->redirect($this->generateUrl('anticom_showcase_blog_show', ['id' => $blogEntry->getId()]));
        }

        return $this->render(
            'AnticomShowcaseBundle:Comment:new.html.twig',
            [
                'form'          => $form->createView(),
                'blogEntry'     => $blogEntry,
                'parentComment' => $parentComment,
                'rootComment'   => $rootComment
            ]
        );
    }
} 