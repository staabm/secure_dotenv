<?php

namespace staabm\SecureDotenv\KeySource;

use staabm\SecureDotenv\KeySource;

class KeyString extends KeySource
{
    /**
     * Init the object and read the file to get the key contents.
     *
     * @param string $source File path for the key
     */
    public function __construct(
        #[\SensitiveParameter]
        string $source
    )
    {
        $this->setContent($source);
    }
}
