<?php
/**
 * CommentController.php
 * 
 * Date: 20.03.14
 * Time: 15:01
 * @author Timo Mühlbach
 * @namespace Anticom\ShowcaseBundle\Controller
 */

namespace Anticom\ShowcaseBundle\Controller;

use Anticom\ShowcaseBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommentController extends Controller {
    public function newAction($blogEntry, $comment = null) {
        $blogEntry = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:BlogEntry')->find($blogEntry);
        if(!$blogEntry) throw $this->createNotFoundException('Der Blogeintrag konnte nicht gefunden werden!');

        $rootComment = null;
        if($comment != null) {
            /** @var Comment $comment */
            $comment = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:Comment')->find($comment);
            if(!$blogEntry) throw $this->createNotFoundException('Der Kommentar zum Blogeintrag konnte nicht gefunden werden!');

            $rootComment = $comment;
            while($rootComment->getParent() !== null) {
                $rootComment = $rootComment->getParent();
            }
        }

        return $this->render(
            'AnticomShowcaseBundle:Comment:new.html.twig',
            [
                'blogEntry'   => $blogEntry,
                'comment'     => $comment,
                'rootComment' => $rootComment
            ]
        );
    }

    /**
     * @todo Implement proper view and business logic
     */
    public function editAction($blogEntry, $comment = null) {
        $blogEntry = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:BlogEntry')->find($blogEntry);
        if(!$blogEntry) throw $this->createNotFoundException('Der Blogeintrag konnte nicht gefunden werden!');

        $rootComment = null;
        if($comment != null) {
            /** @var Comment $comment */
            $comment = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:Comment')->find($comment);
            if(!$blogEntry) throw $this->createNotFoundException('Der Kommentar zum Blogeintrag konnte nicht gefunden werden!');

            $rootComment = $comment;
            while($rootComment->getParent() !== null) {
                $rootComment = $rootComment->getParent();
            }
        }

        return $this->render(
            'AnticomShowcaseBundle:Comment:edit.html.twig',
            [
                'blogEntry'   => $blogEntry,
                'comment'     => $comment,
                'rootComment' => $rootComment
            ]
        );
    }
} 