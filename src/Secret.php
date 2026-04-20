<?php

namespace staabm\SecureDotenv;

use JsonSerializable;

interface Secret extends JsonSerializable
{
    public function asString(): string;
}
