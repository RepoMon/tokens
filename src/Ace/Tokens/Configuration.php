<?php namespace Ace\Tokens;

/*
 * @author tim rodger
 * Date: 29/03/15
 */
class Configuration
{
    public function getEncryptionKey()
    {

    }

    public function getStoreDsn()
    {
        // should contain a string like this 'tcp://172.17.0.154:6379'
        return getenv('REDIS_PORT');
    }
}