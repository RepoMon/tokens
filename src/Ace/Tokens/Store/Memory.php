<?php namespace Ace\Tokens\Store;

use Ace\Tokens\Configuration;

/**
 * Stores tokens in memory
 * @package Ace\Tokens\Store
 */
class Memory implements StoreInterface
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var Encryption
     */
    private $encryption;

    /**
     * @param Encryption $encryption
     */
    public function __construct(Encryption $encryption)
    {
        $this->encryption = $encryption;
    }

    /**
     * @param $key
     * @return string
     * @throws UnavailableException
     */
    public function get($key)
    {
        if (isset($this->data[$key])){
            return $this->encryption->decrypt($this->data[$key]);
        } else {
            throw new MissingException("Key '$key' not found");
        }
    }

    /**
     * @param $key
     */
    public function add($key, $value)
    {
        $this->data [$key]= $this->encryption->encrypt($value);
    }

    /**
     * @param $key
     */
    public function remove($key)
    {
        unset($this->data[$key]);
    }

    /**
     * @return array
     */
    public function all()
    {
        return array_keys($this->data);
    }
}