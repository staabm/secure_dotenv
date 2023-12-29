<?php

namespace staabm\SecureDotenv\KeySource;

use InvalidArgumentException;
use staabm\SecureDotenv\KeySource;

class KeyFile extends KeySource
{
    /**
     * Init the object and set the value directly from the string.
     *
     * @param string $source Key file path
     * @throws InvalidArgumentException If the file path is invalid
     */
    public function __construct(string $source)
    {
        if (!is_file($source)) {
            throw new InvalidArgumentException('Invalid source: ' . $source);
        }
        $this->setContent(file_get_contents($source));
    }
}
