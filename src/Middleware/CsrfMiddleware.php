<?php

/** CSRF Middleware **/

/** Namespace **/
namespace Turbo\Middleware;

/** Use Libs **/
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/** CsrfMiddleware **/
class CsrfMiddleware extends \Turbo\Middleware\Middleware
{

    public function __invoke(Request $request, Response $response, $next)
    {
        /** Global **/
        $this->container->view->getEnvironment()->addGlobal('csrf', '<input type="hidden" name="' . $this->container->csrf->getTokenNameKey() . '" value="' . $this->container->csrf->getTokenName() . '"><input type="hidden" name="' . $this->container->csrf->getTokenValueKey() . '" value="' . $this->container->csrf->getTokenValue() . '">');

        /** Return Response **/
        $response = $next($request, $response);
        return $response;
    }

}
