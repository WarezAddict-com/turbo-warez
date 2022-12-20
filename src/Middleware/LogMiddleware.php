<?php

/** Log Middleware **/

/** Namespace **/
namespace Turbo\Middleware;

/** Use Libs **/
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/** LogMiddleware **/
class LogMiddleware extends \Turbo\Middleware\Middleware
{

    public function __invoke(Request $request, Response $response, $next)
    {

        /** Data **/
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();
        $params = $request->getParams();

        /** Logger **/
        $logger = $this->container->get('logger');

        $logger->debug('ERROR', [
            'Method' => $method,
            'Path' => $path,
            'Params' => $params,
        ]);

        /** Return Response **/
        $response = $next($request, $response);
        return $response;
    }

}
