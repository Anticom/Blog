<?php

namespace Anticom\ShowcaseBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AnticomAccessDeniedListener implements AccessDeniedHandlerInterface {
    private $session;

    public function __construct(Session $session) {
        $this->session = $session;
    }

    /**
     * Handles an access denied failure.
     *
     * @param Request               $request
     * @param AccessDeniedException $accessDeniedException
     *
     * @return Response may return null
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException) {
        $this->session->getFlashBag()->add('error', 'Sie müsssen eingeloggt sein, um diesen Bereich betreten zu können.');
        $this->session->getFlashBag()->add('info', 'Bitte melden Sie sich an.');
    }

} 