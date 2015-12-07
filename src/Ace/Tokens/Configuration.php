<?php namespace Ace\Tokens;

/*
 * @author tim rodger
 * Date: 29/03/15
 */
class Configuration
{
    /**
     * key length must be exactly 256 bits (32 bytes)
     * @return string
     */
    public function getEncryptionKey()
    {
        return getenv('TOKEN_ENCRYPTION_KEY');
    }

    /**
     * @return string
     */
    public function getEncryptionMethod()
    {
        return 'AES-256-CTR';
    }

    /**
     * nonce length must be exactly 128 bits (16 bytes)
     * @return string
     */
    public function getEncryptionNonce()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getStoreDsn()
    {
        // should contain a string like this 'tcp://172.17.0.154:6379'
        return getenv('REDIS_PORT');
    }

    /**
     * @return string
     */
    public function getRabbitHost()
    {
        return getenv('rabbitmq');
    }

    /**
     * @return string
     */
    public function getRabbitPort()
    {
        return 5672;
    }

    /**
     * @return string
     */
    public function getRabbitChannelName()
    {
        // use an env var for the channel name too
        return 'repo-mon.main';
    }
}