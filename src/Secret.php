<?php

namespace staabm\SecureDotenv;

use JsonSerializable;

interface Secret extends JsonSerializable
{
    /**
     * @throws SecretNotDecryptableException
     */
    public function asString(): string;
}
