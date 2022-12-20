<?php

/** Namespace **/
namespace Turbo\Controllers;

/** Use Libs **/
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Tmdb\Model\Search\SearchQuery;

/** SearchController **/
class SearchController extends \Turbo\Controllers\Controller
{

    /** SearchGet **/
    public function SearchGet(Request $request, Response $response, array $args)
    {
        /** Flash Message **/
        if (getenv('APP_DEBUG') == 'yes') {
            $this->flash->addMessageNow('info', 'Debug Mode Enabled!');
        }

        /** Pagination **/
        $pageParam = $request->getParam('page');
        $currentPage = 1;

        if ($pageParam && $pageParam >= 2 && filter_var($pageParam, FILTER_VALIDATE_INT)) {
            $currentPage = $pageParam + 0;
        }

        /** Search Query **/
        $getQuery = $request->getParam('s');
        $query = '';

        if ($getQuery != '') {
            $query = filter_var($getQuery, FILTER_SANITIZE_STRING);
        }

        if ($query != '' && $currentPage != '') {

            /** TMDB API Client **/
            $client = $this->tmdb;

            $searchData = $client->getSearchApi()->searchMovies($query, [
                'page' => $currentPage,
            ]);

            /** Return View **/
            return $this->view->render($response, 'search.twig', [
                'query' => $query,
                'currentPage' => $currentPage,
                'totalPages' => $searchData['total_pages'],
                'totalResults' => $searchData['total_results'],
                'results' => $searchData['results'],
            ]);

        } else {

            return $this->view->render($response, 'search.twig', [
                'query' => $query,
                'currentPage' => 1,
                'totalPages' => 1,
                'totalResults' => 0,
                'results' => '',
            ]);

        }

    }

    /** SearchPost **/
    public function SearchPost(Request $request, Response $response, array $args)
    {
        /** Flash Message **/
        if (getenv('APP_DEBUG') == 'yes') {
            $this->flash->addMessageNow('info', 'Debug Mode Enabled!');
        }

        /** Search Query **/
        $query = '';

        if ($_POST['s']) {
            $query = filter_var($_POST['s'], FILTER_SANITIZE_STRING);
        }

        if ($query != '') {

            /** TMDB API **/
            $client = $this->tmdb;

            $data = $client->getSearchApi()->searchMovies($query, [
                'language' => 'en',
                'page' => 1,
            ]);

            /** Return View **/
            return $this->view->render($response, 'search.twig', [
                'query' => $query,
                'currentPage' => 1,
                'totalPages' => 1,
                'totalResults' => $data['total_results'],
                'results' => $data['results'],
            ]);

        } else {

            /** Return View **/
            return $this->view->render($response, 'search.twig', [
                'query' => $query,
                'currentPage' => 1,
                'totalPages' => 1,
                'totalResults' => 0,
                'results' => '',
            ]);

        }

    }

}
