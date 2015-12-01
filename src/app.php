<?php

require_once __DIR__ . '/vendor/autoload.php';

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Monolog\Logger;
use Monolog\Handler\ErrorLogHandler;

use Ace\Tokens\Provider\ConfigProvider;

use Predis\Client;

$app = new Application();

$app['logger'] = new Logger('log');
$app['logger']->pushHandler(new ErrorLogHandler());


$app->register(new ConfigProvider());


/**
 * Return token for the key
 */
$app->get('/tokens/{key}', function(Request $request) use ($app){

    // get token from redis

    // decrypt

    // return value

});

/**
 * Add token for the key
 */
$app->put('/tokens/{key}', function(Request $request) use ($app){


});

/**
 * Remove token for the key
 */
$app->delete('/tokens/{key}', function(Request $request) use ($app){


});

/**
 */
$app->error(function (Exception $e, $code) use($app) {
    $app['logger']->addError($e->getMessage());
    return new Response($e->getMessage());
});

return $app;