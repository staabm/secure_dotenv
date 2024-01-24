<?php

namespace staabm\SecureDotenv;

use PHPUnit\Framework\TestCase;
use staabm\SecureDotenv\KeySource\KeyString;

/**
 * @internal
 */
class CryptoTest extends TestCase
{
    public function testSetKeyOnInit()
    {
        $keyString = '123456';
        $c = new Crypto($keyString);
        $k = $c->getKey();

        static::assertInstanceOf(KeyString::class, $k);
        static::assertEquals($k->getContent(), $keyString);
    }

    public function testGetSetKey()
    {
        $keyString = '123456';
        $c = new Crypto($keyString);

        static::assertEquals($c->getKey()->getContent(), $keyString);

        // Reset it
        $key = new KeyString('test123');
        $c->setKey($key);

        static::assertEquals($c->getKey()->getContent(), 'test123');
    }

    public function testEncryptDecrypt()
    {
        $value = 'test1234';
        $c = new Crypto(__DIR__ . '/test-encryption-key.txt');
        $encrypted = $c->encrypt($value);

        static::assertNotEquals($value, $encrypted);
        static::assertEquals($value, $c->decrypt($encrypted));
    }

    public function testDecryptWithInvalidValue()
    {
        $c = new Crypto(__DIR__ . '/test-encryption-key.txt');

        static::assertNull($c->decrypt('invalid_value'));
    }
}
