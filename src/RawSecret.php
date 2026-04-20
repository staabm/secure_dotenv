<?php

namespace staabm\SecureDotenv;

use JsonSerializable;

/**
 * Mainly useful for unit-tests or example/dummy/fake-secrets
 */
final class RawSecret implements JsonSerializable
{
    public function __construct(
        private string $secret
    ) {}

    public function asString(): string {
        return $this->secret;
    }

    public function jsonSerialize(): string
    {
        return $this->asString();
    }
}