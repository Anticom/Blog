<?php

namespace Anticom\ShowcaseBundle\Controller;

use Anticom\ShowcaseBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller {
    public function indexAction() {
        //$this->get('session')->getFlashBag()->add('success', 'Ihr Eintrag wurde gespeichert');

        $blogEntries = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:BlogEntry')->findAll();

        return $this->render(
            'AnticomShowcaseBundle:Blog:index.html.twig',
            [
                'blogEntries' => $blogEntries
            ]
        );
    }

    public function showAction($id) {
        $blogEntry = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:BlogEntry')->find($id);

        return $this->render(
            'AnticomShowcaseBundle:Blog:show.html.twig',
            [
                'blogEntry' => $blogEntry
            ]
        );
    }

    public function addCommentAction($blogEntry, $comment = null) {
        $blogEntry = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:BlogEntry')->find($blogEntry);

        $rootComment = null;
        if($comment != null) {
            /** @var Comment $comment */
            $comment = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:Comment')->find($comment);

            $rootComment = $comment;
            while($rootComment->getParent() !== null) {
                $rootComment = $rootComment->getParent();
            }
        }

        return $this->render(
            'AnticomShowcaseBundle:Blog:comment_add.html.twig',
            [
                'blogEntry'   => $blogEntry,
                'comment'     => $comment,
                'rootComment' => $rootComment
            ]
        );
    }
}