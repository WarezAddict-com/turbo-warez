<?php

/** Slim Handlers **/

/** Use Libs **/
use \Psr\Container\ContainerInterface as Container;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/** Not Found Handler **/
unset($app->getContainer()['notFoundHandler']);

$app->getContainer()['notFoundHandler'] = function (Container $container) {
    return function (Request $request, Response $response) use ($container) {

        /** Data **/
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();
        $params = $request->getParams();

        /** Logger **/
        $logger = $container->get('logger');

        $logger->debug('ERROR', [
            'Code' => '404',
            'Message' => 'Not Found',
            'Method' => $method,
            'Path' => $path,
            'Params' => $params,
        ]);

        /** Slim Response **/
        $response = new \Slim\Http\Response(404);
        $response = $response->withHeader('Content-Type', 'text/html; charset=UTF-8');

        /** Return View **/
        return $container->view->render($response, 'error.twig', [
            'status' => 'Error',
            'code' => '404',
            'message' => 'Not Found',
            'method' => $method,
            'path' => $path,
            'params' => $params,
        ]);

    };
};

/** Not Allowed Handler **/
unset($app->getContainer()['notAllowedHandler']);

$app->getContainer()['notAllowedHandler'] = function (Container $container) {
    return function (Request $request, Response $response, $methods) use ($container) {

        /** Data **/
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();
        $params = $request->getParams();

        /** Logger **/
        $logger = $container->get('logger');

        $logger->debug('ERROR', [
            'Code' => '405',
            'Message' => 'Not Allowed',
            'Method' => $method,
            'Path' => $path,
            'Params' => $params,
        ]);

        /** Slim Response **/
        $response = new \Slim\Http\Response(405);
        $response = $response->withHeader('Content-Type', 'text/html; charset=UTF-8');

        /** Return View **/
        return $container->view->render($response, 'error.twig', [
            'status' => 'Error',
            'code' => '405',
            'message' => 'Not Allowed',
            'method' => $method,
            'path' => $path,
            'params' => $params,
        ]);

    };
};

/** Error Handler **/
unset($app->getContainer()['errorHandler']);

$app->getContainer()['errorHandler'] = function (Container $container) {
    return function (Request $request, Response $response, $exception) use ($container) {

        /** Rewind Body **/
        $response->getBody()->rewind();

        /** Data **/
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();
        $params = $request->getParams();

        /** Logger **/
        $logger = $container->get('logger');

        $logger->debug('ERROR', [
            'Code' => $exception->getCode(),
            'Message' => $exception->getMessage(),
            'File' => $exception->getFile(),
            'Line' => $exception->getLine(),
            'Method' => $method,
            'Path' => $path,
            'Params' => $params,
        ]);

        /** Return View **/
        return $container->view->render($response, 'error.twig', [
            'status' => 'Error',
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'method' => $method,
            'path' => $path,
            'params' => $params,
        ]);

    };
};

/** PHP Error Handler **/
unset($app->getContainer()['phpErrorHandler']);

$app->getContainer()['phpErrorHandler'] = function (Container $container) {
    $error = $container['errorHandler'];
    return $error;
};
