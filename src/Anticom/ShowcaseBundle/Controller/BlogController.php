<?php

namespace Anticom\ShowcaseBundle\Controller;

use Anticom\ShowcaseBundle\Entity\BlogEntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller {
    const RECORDS_PER_PAGE = 10;

    public function listAction($page) {
        /** @var BlogEntryRepository $blogRepository */
        $blogRepository = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:BlogEntry');

        $pageInfo            = [];
        $pageInfo['current'] = $page;
        $pageInfo['count']   = ceil(count($blogRepository->findAll()) / self::RECORDS_PER_PAGE);
        $pageInfo['hasPrev'] = $page > 1;
        $pageInfo['hasNext'] = $page < $pageInfo['count'];

        $offset      = self::RECORDS_PER_PAGE * ($page - 1);
        $blogEntries = $blogRepository->findBy([], ['id' => 'ASC'], self::RECORDS_PER_PAGE, $offset);
        if(empty($blogEntries)) throw $this->createNotFoundException('Es konnten keine Blogeinträge gefunden werden!');

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
        if(!$blogEntry) throw $this->createNotFoundException('Der Blogeintrag konnte nicht gefunden werden!');

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
}