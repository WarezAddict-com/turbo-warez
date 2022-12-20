<?php

/** API Controller **/

/** Namespace **/
namespace Turbo\Controllers;

/** Use Libs **/
use \Turbo\Controllers\Controller as Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Curl\Curl;

/** ApiController **/
class ApiController extends Controller
{

    /** Main **/
    public function Main(Request $request, Response $response, array $args)
    {

        $data = [
            'status' => 'ok',
            'base-url' => $request->getUri()->getBaseUrl() . '/api',
            'endpoints' => [
                '/movies' => 'Lists movies now playing in theaters',
                '/torrents' => 'Latest torrents from YTS.mx',
            ],
            'time' => time(),
        ];

        return $response->withJson($data, 200, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    }

    /**  **/
    public function getMovies(Request $request, Response $response, array $args)
    {

        /** TMDB API **/
        $client = $this->tmdb;
        $repo = new \Tmdb\Repository\MovieRepository($client);
        $api = $repo->getApi();

        $temp = $api->getNowPlaying([
            'language' => 'en',
            'page' => 1,
        ]);

        /** Return Json **/
        return $response->withJson($temp['results'], 200, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

    }

    public function getTorrents(Request $request, Response $response, array $args)
    {
        $errors = [];

        $curl = new Curl();

        $curl->setOpt(CURLOPT_SSL_VERIFYPEER , false);
        $curl->setOpt(CURLOPT_SSL_VERIFYSTATUS, false);
        $curl->setOpt(CURLOPT_RETURNTRANSFER, true);
        $curl->setHeader('Accept', 'application/json');
        $curl->setHeader('User-Agent', 'WarezAddict-com (https://warezaddict.com) Movie Database');

        $page = 1;

        $query = '';

        $curl->get('https://yts.mx/api/v2/list_movies.json', [
            'limit' => 10,
            'page' => $page,
            'sort_by' => 'date_added', /** title, year, rating, peers, seeds, download_count, like_count, date_added **/
            'order_by' => 'desc', /** desc or asc **/
            'query_term' => $query,
        ]);

        if ($curl->error) {
            $errors = [
                'code' => $curl->errorCode,
                'message' => $curl->errorMessage,
            ];

            return $response->withHeader('Content-Type', 'application/json')->withJson($errors, 200, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        } else {

            $resp = $curl->response;
            $status = $resp->status;

            if ($status = 'ok') {

                /** Return JSON **/
                return $response->withHeader('Content-Type', 'application/json')->withJson($resp->data->movies, 200, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

            } else {

                $errors = [
                    'code' => '500',
                    'message' => 'Error!',
                ];

                return $response->withHeader('Content-Type', 'application/json')->withJson($errors, 200, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

            }

        }

    }

}
