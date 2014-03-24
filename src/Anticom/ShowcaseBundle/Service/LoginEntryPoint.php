<?php

namespace Anticom\ShowcaseBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * When the user is not authenticated at all (i.e. when the security context has no token yet),
 * the firewall's entry point will be called to start() the authentication process.
 */

class LoginEntryPoint implements AuthenticationEntryPointInterface {
    protected $router;

    public function __construct(RouterInterface $router) {
        $this->router = $router;

    }

    /**
     * Starts the authentication scheme.
     *
     * @param Request                 $request       The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null) {
        $session = $request->getSession();
        $session->getFlashBag()->add('warning', 'Bitte melden Sie sich an, um die gewünschte Seite besuchen zu können!');

        return new RedirectResponse($this->router->generate('login'));
    }


}