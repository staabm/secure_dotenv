<?php

namespace staabm\SecureDotenv;

use LogicException;

use function sprintf;

final class LazySecret implements Secret
{
    private string $identifier;

    /**
     * @var null|callable(): ?string
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
    public function asString(): string
    {
        if (null === $this->decrypted) {
            if (null === $this->decrypter) {
                throw new LogicException();
            }

            $decrypted = ($this->decrypter)();
            if (null === $decrypted) {
                throw new SecretNotDecryptableException(sprintf('Unable to decrypt secret %s', $this->identifier));
            }
            $this->decrypted = $decrypted;
            $this->decrypter = null; // free memory
        }
        return $this->decrypted;
    }

    public function jsonSerialize(): string
    {
        return $this->asString();
    }
}
