<?php

/** Slash Middleware **/

/** Namespace **/
namespace Turbo\Middleware;

/** Use Libs **/
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/** SlashMiddleware **/
class SlashMiddleware extends \Turbo\Middleware\Middleware
{

    public function __invoke(Request $request, Response $response, $next)
    {
        /** Redirect Trailing Slash To Non-Trailing Paths **/

        $uri = $request->getUri();
        $path = $uri->getPath();

        if ($path != '/' && substr($path, -1) == '/') {

            $uri = $uri->withPath(substr($path, 0, -1));

            if ($request->getMethod() == 'GET') {
                return $response->withRedirect((string)$uri, 301);
            } else {
                return $next($request->withUri($uri), $response);
            }

        }

        /** Return Response **/
        $response = $next($request, $response);
        return $response;
    }

}
