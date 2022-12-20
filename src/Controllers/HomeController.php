<?php

/** Home Controller **/

/** Namespace **/
namespace Turbo\Controllers;

/** Use Libs **/
use \Turbo\Controllers\Controller as Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/** HomeController **/
class HomeController extends Controller
{

    /** Home **/
    public function Home(Request $request, Response $response, array $args)
    {

        /** Flash Message **/
        if (getenv('APP_DEBUG') == 'yes') {
            $this->flash->addMessageNow('debug', 'Debug Mode Enabled!');
        }

        /** Pagination **/
        $pageParam = $request->getParam('page');
        $currentPage = 1;

        if ($pageParam != '') {

            if ($pageParam >= 2 && $pageParam <= 99 && filter_var($pageParam, FILTER_VALIDATE_INT)) {
                $currentPage = $pageParam + 0;
            }

        } else {
            $currentPage = 1;
        }

        /** TMDB API Client **/
        $client = $this->tmdb;

        $movieRepo = new \Tmdb\Repository\MovieRepository($client);
        $repo = $movieRepo->getApi();

        $nowPlay = $repo->getNowPlaying([
            'language' => 'en',
            'page' => $currentPage,
        ]);

        if ($nowPlay['results'] != '') {

            /** Return View **/
            return $this->view->render($response, 'home.twig', [
                'currentPage' => $currentPage,
                'totalPages' => $nowPlay['total_pages'],
                'totalResults' => $nowPlay['total_results'],
                'results' => $nowPlay['results'],
            ]);

        } else {

            /** Return View **/
            return $this->view->render($response, 'home.twig', [
                'currentPage' => 1,
                'totalPages' => 1,
                'totalResults' => 0,
                'results' => '',
            ]);

        }

    }

}
