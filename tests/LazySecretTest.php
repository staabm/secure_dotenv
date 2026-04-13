<?php

namespace staabm\SecureDotenv;

use PHPUnit\Framework\TestCase;

class LazySecretTest extends TestCase {
    public function testDecryptOnce() {
        $i = 0;
        $lazy = new LazySecret('id', function() use (&$i) {
            $i++;
            return 'abc';
        });
        $lazy->__toString();
        $lazy->__toString();
        $lazy->__toString();
        $this->assertSame(1, $i);
    }
}