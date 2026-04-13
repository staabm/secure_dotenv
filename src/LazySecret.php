<?php

namespace staabm\SecureDotenv;

use RuntimeException;

use function sprintf;

final class LazySecret
{
    private string $identifier;

    /**
     * @var callable(): ?string
     */
    private $decrypter;

    /**
     * @param callable(): ?string $decrypter
     */
    public function __construct(
        string $identifier,
        callable $decrypter
    ) {
        $this->identifier = $identifier;
        $this->decrypter = $decrypter;
    }

    public function __toString(): string
    {
        $decrypted = ($this->decrypter)();
        if (null === $decrypted) {
            throw new RuntimeException(sprintf('Unable to decrypt secret %s', $this->identifier));
        }
        return $decrypted;
    }
}
