<?php

namespace Anticom\ShowcaseBundle\Controller;

use Anticom\ShowcaseBundle\Entity\BlogEntry;
use Anticom\ShowcaseBundle\Entity\BlogEntryRepository;
use Anticom\ShowcaseBundle\Form\Type\BlogEntryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BlogController extends Controller {
    const RECORDS_PER_PAGE = 10;

    public function listAction($page) {
        /** @var BlogEntryRepository $blogRepository */
        $blogRepository = $this->getDoctrine()->getRepository('AnticomShowcaseBundle:BlogEntry');

        $pageInfo    = $blogRepository->getPageInfo($page, self::RECORDS_PER_PAGE);
        $blogEntries = $blogRepository->findByPage($page, self::RECORDS_PER_PAGE);

        if(empty($blogEntries)) {
            //throw $this->createNotFoundException('Es konnten keine Blogeinträge gefunden werden!');
            $this->get('session')->getFlashBag()->add('notice', 'Es ist noch kein Blogeintrag vorhanden. Bitte legen Sie einen an.');
            return $this->redirect($this->generateUrl('anticom_showcase_blog_new'));
        }

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
        if(!$this->getUser()) {
            throw new AccessDeniedException();
        }

        $blogEntry = new BlogEntry();
        $blogEntry->setAuthor($this->getUser());
        $form = $this->createForm(new BlogEntryType(), $blogEntry);

        $form->handleRequest($request);
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blogEntry);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Ihr Blogeintrag wurde erfolgreich gespeichert!');
            return $this->redirect($this->generateUrl('anticom_showcase_blog_list'));
        }

        return $this->render(
            'AnticomShowcaseBundle:Blog:new.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @ParamConverter("blogEntry", class="AnticomShowcaseBundle:BlogEntry")
     */
    public function editAction(Request $request, BlogEntry $blogEntry) {
        if(!$this->getUser()) {
            throw new AccessDeniedException();
        }
        if($this->getUser() != $blogEntry->getAuthor()) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new BlogEntryType(), $blogEntry);

        $form->handleRequest($request);
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blogEntry);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Ihr Blogeintrag wurde erfolgreich aktuallisiert!');
            return $this->redirect($this->generateUrl('anticom_showcase_blog_list'));
        }

        return $this->render(
            'AnticomShowcaseBundle:Blog:edit.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @ParamConverter("blogEntry", class="AnticomShowcaseBundle:BlogEntry")
     */
    public function deleteAction(Request $request, BlogEntry $blogEntry) {
        if(!$this->getUser()) {
            throw new AccessDeniedException();
        }
        if($this->getUser() != $blogEntry->getAuthor()) {
            throw new AccessDeniedException();
        }

        $form = $this->createFormBuilder()
            ->add('confirm', 'submit', ['label' => 'Ja', 'attr' => ['class' => 'btn btn-primary']])
            ->getForm();

        $form->handleRequest($request);
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blogEntry);
            $em->remove($blogEntry);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Ihr Blogeintrag wurde erfolgreich gelöscht!');
            return $this->redirect($this->generateUrl('anticom_showcase_blog_list'));
        }

        return $this->render(
            'AnticomShowcaseBundle:Blog:delete.html.twig',
            [
                'form'      => $form->createView(),
                'blogEntry' => $blogEntry
            ]
        );
    }
}