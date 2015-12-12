<?php namespace Ace\Tokens\Queue;

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * @author timrodger
 * Date: 05/12/15
 */
class QueueClient
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $port;

    /**
     * @var string
     */
    private $channel_name;

    /**
     * @param $host
     * @param $port
     * @param $channel_name
     */
    public function __construct($host, $port, $channel_name)
    {
        $this->host = $host;
        $this->port = $port;
        $this->channel_name = $channel_name;
    }

    /**
     * @param callable $callback
     */
    public function connect(callable $callback)
    {
        printf(" %s host %s port %s channel %s\n", __METHOD__, $this->host, $this->port, $this->channel_name);

        $connection = new AMQPStreamConnection($this->host, $this->port, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->exchange_declare($this->channel_name, 'fanout', false, false, false);

        list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

        $channel->queue_bind($queue_name, $this->channel_name);

        $channel->basic_consume($queue_name, '', false, true, false, false, $callback);

        while(count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();

    }
}