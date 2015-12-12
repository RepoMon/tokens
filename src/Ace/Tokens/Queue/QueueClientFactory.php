<?php namespace Ace\Tokens\Queue;

use Ace\Tokens\Configuration;
use Ace\Tokens\Queue\QueueClient;

/**
 * @author timrodger
 * Date: 07/12/15
 */
class QueueClientFactory
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
     * @return QueueClient
     */
    public function create()
    {
        return new QueueClient(
            $this->config->getRabbitHost(),
            $this->config->getRabbitPort(),
            $this->config->getRabbitChannelName()
        );
    }
}