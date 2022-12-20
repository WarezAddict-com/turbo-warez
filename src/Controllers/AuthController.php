<?php

/** Namespace **/
namespace Turbo\Controllers;

/** Use Libs **/
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/** AuthController **/
class AuthController extends \Turbo\Controllers\Controller
{
    /** LoginGet **/
    public function LoginGet(Request $request, Response $response, array $args)
    {
        /** Debug **/
        $debug = 0;

        /** Flash Message **/
        if (getenv('APP_DEBUG') == 'yes') {
            $debug = 1;
            $this->flash->addMessageNow('debug', 'Debug Mode Enabled!');
        }

        /** Return View **/
        return $this->view->render($response, 'login.twig', [
            'debug' => $debug,
        ]);
    }

    /** LoginPost **/
    public function LoginPost(Request $request, Response $response, array $args)
    {
        /** Debug **/
        $debug = 0;

        /** Flash Message **/
        if (getenv('APP_DEBUG') == 'yes') {
            $debug = 1;
            $this->flash->addMessageNow('debug', 'Debug Mode Enabled!');
        }

        /** Username **/
        $username = $_POST['email'];

        /** Password **/
        $password = $_POST['password'];

        /** Admin Auth **/
        $admin = 0;

        if ($username == 'turbo@warezaddict.com' && $password == 'b4n5h335a') {
            $admin = 1;
        }

        if ($admin == 1) {
            return $this->view->render($response, 'admin.twig', [
                'debug' => $debug,
                'admin' => $admin,
            ]);
        }

        /** Return View **/
        return $this->view->render($response, 'login.twig', [
            'debug' => $debug,
            'username' => $username,
            'password' => $password,
            'admin' => $admin,
        ]);
    }

    /** RegisterGet **/
    public function RegisterGet(Request $request, Response $response, array $args)
    {

        /** Flash Message **/
        if (getenv('APP_DEBUG') == 'yes') {
            $this->flash->addMessageNow('debug', 'Debug Mode Enabled!');
        }

        /** Return View **/
        return $this->view->render($response, 'register.twig', []);
    }

    /** RegisterPost **/
    public function RegisterPost(Request $request, Response $response, array $args)
    {

        /** Flash Message **/
        if (getenv('APP_DEBUG') == 'yes') {
            $this->flash->addMessageNow('debug', 'Debug Mode Enabled!');
        }

        /** Return View **/
        return $this->view->render($response, 'register.twig', []);
    }

}
