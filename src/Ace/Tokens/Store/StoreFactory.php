<?php namespace Ace\Tokens\Store;

use Ace\Tokens\Configuration;
use Predis\Client;

use Ace\Tokens\Store\Redis as RedisStore;
use Ace\Tokens\Store\Memory as MemoryStore;

/**
 * @author timrodger
 * Date: 07/12/15
 */
class StoreFactory
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
     * @return \Ace\Tokens\Store\StoreInterface
     */
    public function create()
    {
        // instantiate a different store depending on the value of $app['config']->getStoreDsn()

        $dsn = $this->config->getStoreDsn();

        $encryption = new Encryption(
            $this->config->getEncryptionMethod(),
            $this->config->getEncryptionKey(),
            $this->config->getEncryptionIvSize()
        );

        if ('MEMORY' == $dsn) {
            $store = new MemoryStore($encryption);
        } else {
            $store = new RedisStore($encryption, new Client($dsn));
        }

        return $store;
    }
}