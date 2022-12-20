<?php

/** Namespace **/
namespace Turbo\Controllers;

/** Use Libs **/
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/** GenreController **/
class GenreController extends \Turbo\Controllers\Controller
{
    /** Genres **/
    public function Genres(Request $request, Response $response, array $args)
    {

        /** Flash Message **/
        if (getenv('APP_DEBUG') == 'yes') {
            $this->flash->addMessageNow('debug', 'Debug Mode Enabled!');
        }

        /** Genre **/
        $genre = $request->getAttribute('genre');

        /** Return View **/
        return $this->view->render($response, 'results.twig', [
            'currentPage' => 1,
            'genre' => $genre,
        ]);
    }

}
