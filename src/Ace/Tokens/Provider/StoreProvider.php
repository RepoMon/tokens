<?php namespace Sce\Tokens\Provider;

use Predis\Client;
use Silex\Application;
use Silex\ServiceProviderInterface;

use Ace\Tokens\Store\Redis as RedisStore;
use Ace\Tokens\Store\Memory as MemoryStore;

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
        // instantiate a different store depending on the value of $app['config']->getStoreDsn()
        $dsn = $app['config']->getStoreDsn();

        if ('MEMORY' == $dsn) {
            $store = new MemoryStore($app['config']);
        } else {
            $store = new RedisStore($app['config'], new Client($dsn));
        }

        $app['git_repo_store'] = $store;
    }
}