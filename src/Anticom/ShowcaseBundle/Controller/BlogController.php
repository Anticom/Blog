<?php

namespace Anticom\ShowcaseBundle\Controller;

use Anticom\ShowcaseBundle\Entity\BlogEntryRepository;
use Anticom\ShowcaseBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller {
    const RECORDS_PER_PAGE = 10;

    public function indexAction($page) {
        /** @var BlogEntryRepository $blogRepository */
        $blogRepository = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:BlogEntry');

        $pageInfo            = [];
        $pageInfo['current'] = $page;
        $pageInfo['count']   = ceil(count($blogRepository->findAll()) / self::RECORDS_PER_PAGE);
        $pageInfo['hasPrev'] = $page > 1;
        $pageInfo['hasNext'] = $page < $pageInfo['count'];

        $offset      = self::RECORDS_PER_PAGE * ($page - 1);
        $blogEntries = $blogRepository->findBy([], ['id' => 'ASC'], self::RECORDS_PER_PAGE, $offset);

        return $this->render(
            'AnticomShowcaseBundle:Blog:list.html.twig',
            [
                'blogEntries' => $blogEntries,
                'page'        => $pageInfo
            ]
        );
    }

    public function showAction($id) {
        /** @var BlogEntryRepository $blogRepository */
        $blogRepository = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:BlogEntry');

        $blogEntry = $blogRepository->find($id);
        $prev = $blogRepository->findPrev($blogEntry);
        $next = $blogRepository->findNext($blogEntry);

        return $this->render(
            'AnticomShowcaseBundle:Blog:show.html.twig',
            [
                'blogEntry' => $blogEntry,
                'prev'      => $prev,
                'next'      => $next
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