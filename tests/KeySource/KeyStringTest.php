<?php

namespace staabm\SecureDotenv\KeySource;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class KeyStringTest extends TestCase
{
    public function testValidInit()
    {
        $keyString = 'test1234';
        $key = new KeyString($keyString);

        static::assertEquals($keyString, $key->getContent());
    }
}
