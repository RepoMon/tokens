<?php
/**
 * @author timrodger
 * Date: 05/12/15
 *
 * Consumes events
 * Adds tokens to the store
 *
 */

// create the application and boot start it, but don't run
$app = require_once __DIR__ . '/app.php';
$app->boot();

$callback = function($msg) use ($app) {

    // add a token
    $app['logger']->notice(sprintf("received %s\n", $msg->body));

    $event = json_decode($msg->body, true);

    if ($event['name'] === 'repo-mon.token.added'){
        $app['store']->add($event['data']['user'], $event['data']['token']);
    }

};

$app['rabbit-client']->connect($callback);
