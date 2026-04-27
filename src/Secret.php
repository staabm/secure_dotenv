<?php

namespace staabm\SecureDotenv;

use JsonSerializable;

interface Secret extends JsonSerializable
{
    /**
     * @throws SecretNotDecryptableException
     *
     * @return non-empty-string
     */
    public function asString(): string;
}
