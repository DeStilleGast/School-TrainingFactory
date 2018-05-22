<?php
/**
 * Created by PhpStorm.
 * User: DeStilleGast
 * Date: 16-5-2018
 * Time: 23:36
 */

namespace AppBundle\Handler;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{

    protected $router;

    protected $authorizationChecker;

    /**
     * LoginSuccessHandler constructor.
     * @param $router
     * @param $authorizationChecker
     */
    public function __construct(RouterInterface $router, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }


    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @return Response never null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if($this->authorizationChecker->isGranted("ROLE_LID")){
            return new RedirectResponse($this->router->generate("lid_home"));
        }

        if($this->authorizationChecker->isGranted("ROLE_INSTRUCTEUR")){
            return new RedirectResponse($this->router->generate("instructeur_home"));
        }

        if($this->authorizationChecker->isGranted("ROLE_ADMIN")){
            return new RedirectResponse($this->router->generate("admin_home"));
        }

        return new RedirectResponse($this->router->generate("homepage"));
    }
}