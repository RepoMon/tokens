<?php namespace Ace\Tokens\Store; 

/**
 * @author timrodger
 * Date: 04/01/16
 */
class Encryption
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $key;

    /**
     * @var integer
     */
    private $iv_size;

    /**
     * @param string $method
     * @param string $key
     */
    public function __construct($method, $key, $iv_size)
    {
        $this->method = $method;
        $this->key = $key;
        $this->iv_size = $iv_size;
    }

    /**
     * @param $string
     * @return string
     */
    public function encrypt($string)
    {
        $iv = openssl_random_pseudo_bytes($this->iv_size);

        $encrypted = openssl_encrypt($string, $this->method, $this->key, false, $iv);

        return $iv.$encrypted;
    }

    /**
     * @param $string
     * @return string
     */
    public function decrypt($string)
    {
        $iv = substr($string, 0, $this->iv_size);

        return openssl_decrypt(substr($string, $this->iv_size), $this->method, $this->key, false, $iv);
    }
}