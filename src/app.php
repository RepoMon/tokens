<?php

require_once __DIR__ . '/vendor/autoload.php';

use Silex\Application;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Monolog\Logger;
use Monolog\Handler\ErrorLogHandler;

use Ace\Tokens\Provider\ConfigProvider;
use Ace\Tokens\Provider\StoreProvider;
use Ace\Tokens\Provider\RabbitConsumerProvider;

$app = new Application();

$app['logger'] = new Logger('log');
$app['logger']->pushHandler(new ErrorLogHandler());

$app->register(new ConfigProvider());
$app->register(new StoreProvider());
//$app->register(new RabbitConsumerProvider());

/**
 * Return token for the key
 */
$app->get('/tokens/{key}', function(Request $request, $key) use ($app){

    return new Response($app['store']->get($key), 200);

});

/**
 * Add token for the key
 */
$app->put('/tokens/{key}', function(Request $request, $key) use ($app){

    $app['store']->add($key, $request->get('token'));

    return new Response('', 200);

});

/**
 * Remove token for the key
 */
$app->delete('/tokens/{key}', function(Request $request, $key) use ($app){

    $app['store']->remove($key);

    return new Response('', 204);
});

/**
 * List all keys
 */
$app->get('/tokens', function(Request $request) use ($app){

    return new Response(
        json_encode($app['store']->all(), JSON_UNESCAPED_SLASHES),
        200
    );
});

/**
 */
$app->error(function (Exception $e, $code) use($app) {
    $app['logger']->addError($e->getMessage());
    return new Response($e->getMessage(), $e->getCode());
});

return $app;