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

use Anticom\ShowcaseBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CommentController extends Controller {
    public function newAction($blogEntry, $parentComment = null) {
        if(!$this->getUser()) throw new AccessDeniedException();

        $blogEntry = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:BlogEntry')->find($blogEntry);
        if(!$blogEntry) throw $this->createNotFoundException('Der Blogeintrag konnte nicht gefunden werden!');

        $rootComment = null;
        if($parentComment != null) {
            /** @var Comment $parentComment */
            $parentComment = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:Comment')->find($parentComment);
            if(!$blogEntry) throw $this->createNotFoundException('Der Kommentar zum Blogeintrag konnte nicht gefunden werden!');

            $rootComment = $parentComment->getRootComment();
        }

        return $this->render(
            'AnticomShowcaseBundle:Comment:new.html.twig',
            [
                'blogEntry'   => $blogEntry,
                'comment'     => $parentComment,
                'rootComment' => $rootComment
            ]
        );
    }

    /**
     * @todo Implement proper view and business logic
     */
    public function editAction($blogEntry, $parentComment = null) {
        if(!$this->getUser()) throw new AccessDeniedException();

        $blogEntry = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:BlogEntry')->find($blogEntry);
        if(!$blogEntry) throw $this->createNotFoundException('Der Blogeintrag konnte nicht gefunden werden!');

        $rootComment = null;
        if($parentComment != null) {
            /** @var Comment $parentComment */
            $parentComment = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:Comment')->find($parentComment);
            if(!$blogEntry) throw $this->createNotFoundException('Der Kommentar zum Blogeintrag konnte nicht gefunden werden!');

            $rootComment = $parentComment->getRootComment();
        }

        return $this->render(
            'AnticomShowcaseBundle:Comment:edit.html.twig',
            [
                'blogEntry'   => $blogEntry,
                'comment'     => $parentComment,
                'rootComment' => $rootComment
            ]
        );
    }
} 