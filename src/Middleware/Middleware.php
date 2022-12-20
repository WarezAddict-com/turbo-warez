<?php

/** Namespace **/
namespace Turbo\Middleware;

/** Use Libs **/
use \Psr\Container\ContainerInterface as Container;

/** Middleware **/
class Middleware
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
}
