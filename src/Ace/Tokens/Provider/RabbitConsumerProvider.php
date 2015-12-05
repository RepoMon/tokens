<?php namespace Ace\Tokens\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Ace\Tokens\RabbitConsumer;

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
        $config = $app['config'];

        $app['rabbit-client'] = new RabbitConsumer(
            $config->getRabbitHost(),
            $config->getRabbitPort(),
            $config->getRabbitChannelName()
        );
    }
}
