<?php

namespace Anticom\ShowcaseBundle\Controller;

use Anticom\ShowcaseBundle\Entity\BlogEntry;
use Anticom\ShowcaseBundle\Entity\BlogEntryRepository;
use Anticom\ShowcaseBundle\Form\Type\BlogEntryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

    public function newAction(Request $request) {
        if(!$this->getUser()) throw new AccessDeniedException();

        $blogEntry = new BlogEntry();
        $form = $this->createForm(new BlogEntryType(), $blogEntry);

        $form->handleRequest($request);
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blogEntry);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Ihr Blogeintrag wurde erfolgreich gespeichert!');
            //$this->redirect($this->generateUrl('anticom_showcase_blog'));
        }

        return $this->render(
            'AnticomShowcaseBundle:Blog:new.html.twig',
            [
                'form'  => $form->createView()
            ]
        );
    }

    /**
     * @ParamConverter("blogEntry", class="AnticomShowcaseBundle:BlogEntry")
     */
    public function editAction(Request $request, BlogEntry $blogEntry) {
        if(!$this->getUser()) throw new AccessDeniedException();

        $form = $this->createForm(new BlogEntryType(), $blogEntry);

        $form->handleRequest($request);
        if($form->isValid()) {
            //TODO handle submission
        }
    }
}