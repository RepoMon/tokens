<?php namespace Sce\Tokens\Store;

use Predis\Response\ServerException;
use Ace\Tokens\Configuration;
use Predis\Client;
use Ace\Tokens\Store\UnavailableException;

/**
 *
 * @author timrodger
 * Date: 17/07/15
 */
class Redis implements StoreInterface
{
    /**
     * @var Configuration
     */
    private $config;

    /**
     * @var Client
     */
    private $client;


    /**
     * @param Configuration $config
     */
    public function __construct(Configuration $config, Client $client)
    {
        $this->config = $config;
        $this->client = $client;
    }

    /**
     * @param $key
     * @return string
     * @throws UnavailableException
     */
    public function get($key)
    {
    }

    /**
     * @param $key
     */
    public function add($key, $value)
    {
    }

    public function remove($key)
    {

    }

 }