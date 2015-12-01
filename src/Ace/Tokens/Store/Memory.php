<?php namespace Ace\Tokens\Store;

use Ace\Tokens\Configuration;

/**
 * @author timrodger
 * Date: 29/03/15
 */
class Memory implements StoreInterface
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @param Configuration $config
     */
    public function __construct(Configuration $config)
    {
    }

    /**
     * @param $key
     * @return string
     * @throws UnavailableException
     */
    public function get($key)
    {
        if (in_array($key, $this->data)){
            return $this->data[$key];
        } else {
            throw new UnavailableException;
        }
    }

    /**
     * @param $key
     */
    public function add($key, $value)
    {
        $this->data [$key]= $value;
    }

    /**
     * @param $key
     */
    public function remove($key)
    {
        unset($this->data[$key]);
    }
}