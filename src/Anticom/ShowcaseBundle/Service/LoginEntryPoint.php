<?php
/**
 * LoginEntryPoint.php
 *
 * @author    Timo M
 * @namespace Anticom\ShowcaseBundle\Service
 * @package   EventListener
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Anticom\ShowcaseBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class LoginEntryPoint
 *
 * When the user is not authenticated at all (i.e. when the security context has no token yet),
 * the firewall's entry point will be called to start() the authentication process.
 */
class LoginEntryPoint implements AuthenticationEntryPointInterface {
    /** @var \Symfony\Component\Routing\RouterInterface Injected Router */
    protected $router;

    /**
     * Inject services here
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router) {
        $this->router = $router;
    }

    /**
     * Starts the authentication scheme.
     *
     * @param Request                 $request       The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null) {
        $session = $request->getSession();
        /** @noinspection PhpUndefinedMethodInspection */
        $session->getFlashBag()->add('warning', 'Bitte melden Sie sich an, um die gewünschte Seite besuchen zu können!');

        return new RedirectResponse($this->router->generate('login'));
    }
}