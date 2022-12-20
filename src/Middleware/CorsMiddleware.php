<?php

/** CORS Middleware **/

/** Namespace **/
namespace Turbo\Middleware;

/** Use Libs **/
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/** CorsMiddleware **/
class CorsMiddleware extends \Turbo\Middleware\Middleware
{

    public function __invoke(Request $request, Response $response, $next)
    {

        /** Response **/
        $response = $next($request, $response);

        /** Powered By **/
        if (getenv('APP_NAME') != '') {
            $pow = getenv('APP_NAME');
        } else {
            $pow = 'WarezAddict.com';
        }

        /** Return Response **/
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('X-Powered-By', $pow);
    }

}
