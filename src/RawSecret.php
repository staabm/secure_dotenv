<?php

namespace staabm\SecureDotenv;

/**
 * Mainly useful for unit-tests or example/dummy/fake-secrets.
 */
final class RawSecret implements Secret
{
    public function __construct(
        private string $secret
    ) {
    }

    public function asString(): string
    {
        return $this->secret;
    }

    public function jsonSerialize(): string
    {
        return $this->asString();
    }
}
