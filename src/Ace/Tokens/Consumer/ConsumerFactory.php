<?php namespace Ace\Tokens\Consumer;

use Ace\Tokens\Configuration;
use Ace\Tokens\Consumer\RabbitConsumer;

/**
 * @author timrodger
 * Date: 07/12/15
 */
class ConsumerFactory
{
    /**
     * @var Configuration
     */
    private $config;

    /**
     * @param Configuration $config
     */
    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    /**
     * @return \Ace\Tokens\Consumer\RabbitConsumer
     */
    public function create()
    {
        return new RabbitConsumer(
            $this->config->getRabbitHost(),
            $this->config->getRabbitPort(),
            $this->config->getRabbitChannelName()
        );
    }
}