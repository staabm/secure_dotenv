<?php

namespace staabm\SecureDotenv;

use PHPUnit\Framework\TestCase;
use function json_encode;

/**
 * @internal
 */
class LazySecretTest extends TestCase
{
    public function testDecryptOnce()
    {
        $i = 0;
        $lazy = new LazySecret('id', static function () use (&$i) {
            ++$i;
            return 'abc';
        });
        $lazy->__toString();
        $lazy->__toString();
        $lazy->__toString();
        static::assertSame(1, $i);
    }

    public function testJsonEncode()
    {
        $constValue = 'abc';
        $lazy = new LazySecret('id', static function () use ($constValue) {
            return $constValue;
        });
        static::assertSame('"abc"', json_encode($constValue));
        static::assertSame('"abc"', json_encode($lazy));

    }

    public function testSecretNotDecryptableException()
    {
        $this->expectException(SecretNotDecryptableException::class);
        $lazy = new LazySecret('id', static function () {
            return null;
        });
        $lazy->__toString();
    }

}
