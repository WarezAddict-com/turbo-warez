<?php

/** Namespace **/
namespace Turbo\Controllers;

/** Use Libs **/
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/** MovieController **/
class MovieController extends \Turbo\Controllers\Controller
{
    /** movieInfo **/
    public function movieInfo(Request $request, Response $response, array $args)
    {

        /** Flash Message **/
        if (getenv('APP_DEBUG') == 'yes') {
            $this->flash->addMessageNow('debug', 'Debug Mode Enabled!');
        }

        /** Data **/
        $data = [];

        /** Movie ID **/
        $id = $args['id'];

        /** TMDB API Client **/
        $client = $this->tmdb;

        /** TMDB Data **/
        $data = $client->getMoviesApi()->getMovie($id);

        /** Return View **/
        return $this->view->render($response, 'info.twig', [
            'id' => $id,
            'results' => $data,
        ]);
    }

}
