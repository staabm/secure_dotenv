<?php

namespace staabm\SecureDotenv;

use PHPUnit\Framework\TestCase;

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
}
