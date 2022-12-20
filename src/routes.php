<?php

/** Slim Routes **/

$app->group('/api', function() use ($app) {

    /** Main API **/
    $app->get('', 'ApiController:Main')->setName('ApiMain');
    $app->get('/movies', 'ApiController:getMovies')->setName('ApiGetMovies');
    $app->get('/torrents', 'ApiController:getTorrents')->setName('ApiGetTorrents');

});

$app->group('', function () {

    /** Home **/
    $this->get('/', 'HomeController:Home')->setName('Home');

    /** Search **/
    $this->get('/search', 'SearchController:SearchGet')->setName('SearchGet');
    $this->post('/search', 'SearchController:SearchPost')->setName('SearchPost');

    /** Movie **/
    $this->get('/movie/{id}', 'MovieController:movieInfo')->setName('MovieInfo');
 
    /** Genres **/
    $this->get('/genre/{genre}', 'GenreController:Genres')->setName('Genres');

    /** Login **/
    $this->get('/login', 'AuthController:LoginGet')->setName('LoginGet');
    $this->post('/login', 'AuthController:LoginPost')->setName('LoginPost');

    /** Register **/
    $this->get('/register', 'AuthController:RegisterGet')->setName('RegisterGet');
    $this->post('/register', 'AuthController:RegisterPost')->setName('RegisterPost');

});
