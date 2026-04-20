<?php

namespace staabm\SecureDotenv;

use PHPUnit\Framework\TestCase;

use function json_encode;

/**
 * @internal
 */
class RawSecretTest extends TestCase
{
    public function testAsString()
    {
        $secret = new RawSecret('my-secret');
        static::assertSame('my-secret', $secret->asString());
    }

    public function testJsonEncode()
    {
        $constValue = 'abc';
        $secret = new RawSecret($constValue);
        static::assertSame('"abc"', json_encode($constValue));
        static::assertSame('"abc"', json_encode($secret));
    }

}
