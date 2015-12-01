<?php

require_once __DIR__ . '/vendor/autoload.php';

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Monolog\Logger;
use Monolog\Handler\ErrorLogHandler;

use Ace\Tokens\Provider\ConfigProvider;
use Ace\Tokens\Provider\StoreProvider;

$app = new Application();

$app['logger'] = new Logger('log');
$app['logger']->pushHandler(new ErrorLogHandler());

$app->register(new ConfigProvider());
$app->register(new StoreProvider());

/**
 * Return token for the key
 */
$app->get('/tokens/{key}', function(Request $request) use ($app, $key){

    return new Response($app['store']->get($key), 200);

});

/**
 * Add token for the key
 */
$app->put('/tokens/{key}', function(Request $request) use ($app, $key){

    $app['store']->add($key, $request->get('token'));

    return new Response('', 200);

});

/**
 * Remove token for the key
 */
$app->delete('/tokens/{key}', function(Request $request) use ($app, $key){

    $app['store']->remove($key);

    return new Response('', 204);
});

/**
 */
$app->error(function (Exception $e, $code) use($app) {
    $app['logger']->addError($e->getMessage());
    return new Response($e->getMessage());
});

return $app;