<?php namespace Ace\Tokens;

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * @author timrodger
 * Date: 05/12/15
 */
class RabbitConsumer
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
        printf(" %s host %s port %s\n", __METHOD__, $this->host, $this->port);

        $connection = new AMQPStreamConnection($this->host, $this->port, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare($this->channel_name, false, false, false, false);

//        $callback = function($event) {
//            echo " Received ", $event->body, "\n";
//        };

        $channel->basic_consume($this->channel_name, '', false, true, false, false, $callback);

        while(count($channel->callbacks)) {
            $channel->wait();
        }


        $channel->close();
        $connection->close();

    }
}