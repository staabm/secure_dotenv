<?php

namespace staabm\SecureDotenv;

use PHPUnit\Framework\TestCase;

use function json_encode;

/**
 * @internal
 */
class RawSecretTest extends TestCase
{
    public function testAsString(): void
    {
        $secret = new RawSecret('my-secret');
        static::assertSame('my-secret', $secret->asString());
    }

    public function testJsonEncode(): void
    {
        $constValue = 'abc';
        $secret = new RawSecret($constValue);
        static::assertSame('"abc"', json_encode($constValue));
        static::assertSame('"abc"', json_encode($secret));
    }
}
