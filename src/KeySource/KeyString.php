<?php

namespace Psecio\SecureDotenv\KeySource;

use InvalidArgumentException;
use Psecio\SecureDotenv\KeySource;

use function is_string;

class KeyString extends KeySource
{
    /**
     * Init the object and read the file to get the key contents.
     *
     * @param string $source File path for the key
     */
    public function __construct(string $source)
    {
        $this->setContent($source);
    }
}
