<?php

namespace Psecio\SecureDotenv\KeySource;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

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
