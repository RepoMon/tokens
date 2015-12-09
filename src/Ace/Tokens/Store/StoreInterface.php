<?php namespace Ace\Tokens\Store;

/**
 * @author timrodger
 * Date: 18/07/15
 */
interface StoreInterface
{
    public function get($key);

    public function add($key, $value);

    public function remove($key);

    public function all();

}