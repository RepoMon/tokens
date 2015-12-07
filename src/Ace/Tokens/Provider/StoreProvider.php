<?php namespace Ace\Tokens\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Ace\Tokens\Store\StoreFactory;

/**
 * @author timrodger
 * Date: 17/07/15
 */
class StoreProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
    }

    public function boot(Application $app)
    {
        $factory = new StoreFactory($app['config']);
        $app['store'] = $factory->create();
    }
}