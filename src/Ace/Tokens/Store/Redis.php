<?php namespace Ace\Tokens\Store;

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
        try {
            $encrypted = $this->client->get($key);
            // decrypt
            return openssl_decrypt($encrypted, $this->config->getEncryptionMethod(), $this->config->getEncryptionKey());
        } catch (ServerException $ex) {
            throw new UnavailableException($ex->getMessage());
        }
    }

    /**
     * @param $key
     */
    public function add($key, $value)
    {
        // $nonce length must be exactly 128 bits (16 bytes)

        // encrypt
        $encrypted = openssl_encrypt($value, $this->config->getEncryptionMethod(), $this->config->getEncryptionKey());

        try {
            $this->client->set($key, $encrypted);
        } catch (ServerException $ex) {
            throw new UnavailableException($ex->getMessage());
        }
    }

    /**
     * @param $key
     */
    public function remove($key)
    {
        try {
            $this->client->del([$key]);
        } catch (ServerException $ex) {
            throw new UnavailableException($ex->getMessage());
        }
    }
 }