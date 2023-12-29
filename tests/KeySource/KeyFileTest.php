<?php

namespace Psecio\SecureDotenv;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Psecio\SecureDotenv\KeySource\KeyFile;

/**
 * @internal
 */
class KeyFileTest extends TestCase
{
    public function testConstructorWithInvalidSource()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid source: invalid_source');

        new KeyFile('invalid_source');
    }
}
