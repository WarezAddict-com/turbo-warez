<?php

/** Slim Dependencies **/

/** Use Libs **/
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ResponseFactoryInterface;
use \Psr\Http\Server\MiddlewareInterface as MiddlewareInterface;
use \Psr\Http\Server\RequestHandlerInterface as RequestHandlerInterface;
use \Slim\Psr7\Factory\ResponseFactory;

/** Slim Container **/
$container = $app->getContainer();

/** Logger **/
$container['logger'] = function ($container) {
    $logPath = APP_ROOT . '/logs/APP_' . date('m-d-Y') . '.log';
    $logger = new \Monolog\Logger('Turbo-Warez');
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($logPath, \Monolog\Logger::DEBUG));
    return $logger;
};

/** CSRF Protection **/
$container['csrf'] = function ($container) {
    $guard = new \Slim\Csrf\Guard();
    $guard->setPersistentTokenMode(true);
    $guard->setFailureCallable(function (\Psr\Http\Message\RequestInterface $request, \Psr\Http\Message\ResponseInterface $response, callable $next) use ($container) {
        $request = $request->withAttribute('CSRF', 'error');
        return $next($request, $response);
    });
    return $guard;
};

/** Flash Messages **/
$container['flash'] = function ($container) {
    return new \Slim\Flash\Messages();
};

/** TMDB API **/
$container['tmdb'] = function ($container) {

    $apiKey = getenv('TMDB_API_KEY');
    $token  = new \Tmdb\ApiToken($apiKey);

    if (getenv('APP_DEBUG') == 'yes') {

        $client = new \Tmdb\Client($token, [
            'secure' => false,
            'cache' => [
                'path' => APP_ROOT . '/cache',
            ],
            'log' => [
                'enabled' => true,
                'path' => APP_ROOT . '/logs/TMDB_' . date('m-d-Y') . '.log',
            ]
        ]);

    } else {

        $client = new \Tmdb\Client($token, [
            'secure' => false,
            'cache' => [
                'path' => APP_ROOT . '/cache',
            ],
            'log' => [
                'enabled' => false,
            ]
        ]);

    }

    $configRepository = new \Tmdb\Repository\ConfigurationRepository($client);
    $config = $configRepository->load();

    $imageHelper = new \Tmdb\Helper\ImageHelper($config);

    $langPlugin = new \Tmdb\HttpClient\Plugin\LanguageFilterPlugin('en');
    $client->getHttpClient()->addSubscriber($langPlugin);

    $adultPlugin = new \Tmdb\HttpClient\Plugin\AdultFilterPlugin(false);
    $client->getHttpClient()->addSubscriber($adultPlugin);

    return $client;
};

/** Twig View **/
$container['view'] = function ($container) {

    $view = new \Slim\Views\Twig(APP_ROOT . '/views', [
        'debug' => true,
        'cache' => false,
        'auto_reload' => true,
        'autoescape' => false,
    ]);

    /** Twig Extensions **/
    $view->addExtension(new \Slim\Views\TwigExtension($container->router, $container->request->getUri()));
    $view->addExtension(new \Knlv\Slim\Views\TwigMessages($container->get('flash')));
    $view->addExtension(new \Twig_Extension_Debug());
    $view->addExtension(new \Twig_Extensions_Extension_Text());
    $view->addExtension(new \Twig_Extensions_Extension_Array());
    $view->addExtension(new \Twig_Extensions_Extension_Date());

    /** Twig Globals **/
    $view->getEnvironment()->addGlobal('BaseUrl', $container['request']->getUri()->getBaseUrl());

    $view->getEnvironment()->addGlobal('TmdbImage', 'http://image.tmdb.org/t/p/w500');

    if ($container['request']->getParams() != '') {
        $view->getEnvironment()->addGlobal('Params', $container['request']->getParams());
    }

    if ($container['request']->getAttributes() != '') {
        $view->getEnvironment()->addGlobal('Attrs', $container['request']->getAttributes());
    }

    if (getenv('APP_DEBUG') == 'yes') {
        $view->getEnvironment()->addGlobal('debug', true);
    } else {
        $view->getEnvironment()->addGlobal('debug', false);
    }

    /** App Info **/
    $view->getEnvironment()->addGlobal('AppName', getenv('APP_NAME'));
    $view->getEnvironment()->addGlobal('AppDesc', getenv('APP_DESC'));
    $view->getEnvironment()->addGlobal('AppKeywords', getenv('APP_KEYWORDS'));
    $view->getEnvironment()->addGlobal('AppEmail', getenv('APP_EMAIL'));

    /** Return View **/
    return $view;
};

/** Controllers **/
$container['HomeController'] = function ($container) {
    return new \Turbo\Controllers\HomeController($container);
};
$container['SearchController'] = function ($container) {
    return new \Turbo\Controllers\SearchController($container);
};
$container['MovieController'] = function ($container) {
    return new \Turbo\Controllers\MovieController($container);
};
$container['GenreController'] = function ($container) {
    return new \Turbo\Controllers\GenreController($container);
};
$container['AuthController'] = function ($container) {
    return new \Turbo\Controllers\AuthController($container);
};
$container['ApiController'] = function ($container) {
    return new \Turbo\Controllers\ApiController($container);
};

/** Slim Middleware **/
$app->add(new \Turbo\Middleware\SlashMiddleware($container));
$app->add(new \Turbo\Middleware\CsrfMiddleware($container));
$app->add($container['csrf']);
$app->add(new \Turbo\Middleware\CorsMiddleware($container));

if (getenv('APP_DEBUG') == 'yes') {
    $app->add(new \Turbo\Middleware\LogMiddleware($container));
}

/** Slim Handlers **/
require_once APP_ROOT . '/src/handlers.php';
