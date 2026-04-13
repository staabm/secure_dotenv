<?php

namespace staabm\SecureDotenv;

use JsonSerializable;

use function sprintf;

final class LazySecret implements JsonSerializable
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
     * @throws SecretNotDecryptableException
     */
    public function __toString(): string
    {
        if (null === $this->decrypted) {
            $decrypted = ($this->decrypter)();
            if (null === $decrypted) {
                throw new SecretNotDecryptableException(sprintf('Unable to decrypt secret %s', $this->identifier));
            }
            $this->decrypted = $decrypted;
        }
        return $this->decrypted;
    }

    public function jsonSerialize(): string
    {
        return $this->__toString();
    }
}
