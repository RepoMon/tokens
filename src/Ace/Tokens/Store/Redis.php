<?php namespace Ace\Tokens\Store;

use Predis\Response\ServerException;
use Predis\Client;

/**
 * Stores tokens using redis
 * @package Ace\Tokens\Store
 */
class Redis implements StoreInterface
{
    /**
     * @var Encryption
     */
    private $encryption;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param Encryption $encryption
     * @param Client $client
     */
    public function __construct(Encryption $encryption, Client $client)
    {
        $this->encryption = $encryption;
        $this->client = $client;
    }

    /**
     * @param $key
     * @return string
     * @throws MissingException
     * @throws UnavailableException
     */
    public function get($key)
    {
        try {
            $encrypted = $this->client->get($key);
            if (empty($encrypted)){
                throw new MissingException("No token found for $key");
            }
            // decrypt to token after retrieval
            return $this->encryption->decrypt($encrypted);
        } catch (ServerException $ex) {
            throw new UnavailableException($ex->getMessage());
        }
    }

    /**
     * @param $key
     * @param $value
     * @throws UnavailableException
     */
    public function add($key, $value)
    {
        // encrypt the tokens before storing in redis
        try {
            $this->client->set($key, $this->encryption->encrypt($value));
        } catch (ServerException $ex) {
            throw new UnavailableException($ex->getMessage());
        }
    }

    /**
     * @param $key
     * @throws UnavailableException
     */
    public function remove($key)
    {
        try {
            $this->client->del([$key]);
        } catch (ServerException $ex) {
            throw new UnavailableException($ex->getMessage());
        }
    }

    /**
     * @return array
     * @throws UnavailableException
     */
    public function all()
    {
        try {
            return $this->client->keys('*');
        } catch (ServerException $ex) {
            throw new UnavailableException($ex->getMessage());
        }
    }
 }