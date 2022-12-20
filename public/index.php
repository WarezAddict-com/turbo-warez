<?php

/** Defines **/
define('WEB_ROOT', __DIR__);
define('APP_ROOT', dirname(__DIR__));

/** Composer Autoload **/
require_once APP_ROOT . '/vendor/autoload.php';

/** PHP Dev Server **/
if (PHP_SAPI == 'cli-server') {
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

/** Load ENV **/
$dotenv = \Dotenv\Dotenv::create(APP_ROOT);
$dotenv->load();

/** Start Session **/
if ('' == session_id()) {
    session_start();
}

/** Slim Settings **/
$settings = include_once APP_ROOT . '/src/settings.php';

/** Slim App **/
$app = new \Slim\App($settings);

/** Slim Dependencies **/
require_once APP_ROOT . '/src/dependencies.php';

/** Slim Routes **/
require_once APP_ROOT . '/src/routes.php';

/** Run Slim PHP **/
$app->run();
