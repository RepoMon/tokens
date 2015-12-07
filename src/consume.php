<?php
/**
 * @author timrodger
 * Date: 05/12/15
 *
 * Consumes events
 * Adds tokens to the store
 *
 */
require_once __DIR__ . '/vendor/autoload.php';

use Ace\Tokens\Store\StoreFactory;
use Ace\Tokens\Consumer\ConsumerFactory;

$config = new Ace\Tokens\Configuration;

$store_factory = new StoreFactory($config);
$store = $store_factory->create();

$consumer_factory = new ConsumerFactory($config);
$consumer = $consumer_factory->create();

$callback = function($event) use ($store) {

    // add a token
    echo " Received ", $event->body, "\n";

    $event = json_decode($event->body);

    if ($event['name'] === 'repo-mon.token.added'){
        $store->add($event['data']['user'], $event['data']['token']);
    }

};

$consumer->connect($callback);
