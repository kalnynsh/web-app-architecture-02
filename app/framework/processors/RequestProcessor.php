<?php

declare(strict_types = 1);

namespace Framework\processors;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;

/**
 * RequestProcessor class
 *
 * @property RouteCollection $routeCollection
 */
class RequestProcessor
{
    protected $routeCollection;

    public function __construct(
        RouteCollection $routeCollection
    ) {
        $this->routeCollection = $routeCollection;
    }

    public function processRequest($request): Response
    {
        $matcher = new UrlMatcher($this->routeCollection, new RequestContext());
        $matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($matcher->match($request->getPathInfo()));
            $request->setSession(new Session());

            $controller = (new ControllerResolver())->getController($request);
            $arguments = (new ArgumentResolver())->getArguments($request, $controller);

            return \call_user_func_array($controller, $arguments);
        } catch (\Throwable $e) {
            return new Response(
                'Server error occured. Status: 500',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
