<?php

/** Slim Settings **/ 

if (getenv('APP_DEBUG') == 'yes') {

    return ['settings' => [
        'debug' => true,
        'displayErrorDetails' => true,
        'addContentLengthHeader' => true,
        'determineRouteBeforeAppMiddleware' => true,
        'routerCacheFile' => false,
    ]];

} else {

    return ['settings' => [
        'debug' => false,
        'displayErrorDetails' => false,
        'addContentLengthHeader' => true,
        'determineRouteBeforeAppMiddleware' => true,
        'routerCacheFile' => false,
    ]];

}
