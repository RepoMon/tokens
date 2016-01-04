<?php

use Ace\Tokens\Store\Encryption;

/**
 * @author timrodger
 * Date: 04/01/16
 */
class EncryptionTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Encryption
     */
    private $encryption;

    public function setUp()
    {
        $this->encryption = new Encryption('AES-256-CBC', 'abcd1234', 16);
    }

    public function testEncrypt()
    {
        $string = 'my big fat secret';
        $encrypted = $this->encryption->encrypt($string);
        $decrypted = $this->encryption->decrypt($encrypted);

        $this->assertSame($string, $decrypted);

    }

    public function testEncryptGeneratesDifferentStringsForSameValue()
    {
        $string = 'my big fat secret';
        $encrypted_1 = $this->encryption->encrypt($string);
        $encrypted_2 = $this->encryption->encrypt($string);

        $this->assertFalse($encrypted_1 == $encrypted_2);

    }
}