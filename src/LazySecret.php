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

    private ?string $decrypted = null;

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

    /**
     * @throws RuntimeException
     */
    public function __toString(): string
    {
        if (null === $this->decrypted) {
            $decrypted = ($this->decrypter)();
            if (null === $decrypted) {
                throw new RuntimeException(sprintf('Unable to decrypt secret %s', $this->identifier));
            }
            $this->decrypted = $decrypted;
        }
        return $this->decrypted;
    }
}
