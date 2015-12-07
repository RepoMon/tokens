<?php namespace Ace\Tokens\Provider;

use Ace\Tokens\Consumer\ConsumerFactory;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * @author timrodger
 * Date: 23/06/15
 */
class RabbitConsumerProvider implements ServiceProviderInterface
{
    /**
     * @param Application $app
     */
    public function register(Application $app)
    {

    }

    /**
     * @param Application $app
     */
    public function boot(Application $app)
    {
        $factory = new ConsumerFactory($app['config']);
        $app['rabbit-client'] = $factory->create();
    }
}
