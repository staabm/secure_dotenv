<?php

namespace Psecio\SecureDotenv;

use Defuse\Crypto\Crypto as DefuseCrypto;
use Defuse\Crypto\Key as DefuseKey;
use InvalidArgumentException;

use function is_string;

class Crypto
{
    /**
     * Current key value (either File or String version).
     *
     * @var KeySource
     */
    private $key;

    /**
     * Init the object and set up the key.
     *
     * @param string $key The "key" value, either a string or a file path
     */
    public function __construct($key)
    {
        $this->setKey($this->createKey($key));
    }

    /**
     * Create the key instance based on either a string or file path.
     *
     * @param string $key The "key" value, either a string or a file path
     * @return KeySource instance
     */
    public function createKey(string $key)
    {
        if (is_file($key)) {
            $key = new KeySource\KeyFile($key);
        } elseif (is_string($key)) {
            $key = new KeySource\KeyString($key);
        } else {
            throw new InvalidArgumentException('Could not create key from value provided.');
        }

        return $key;
    }

    /**
     * Set the currekt key instance.
     *
     * @param KeySource $key instance
     */
    public function setKey(KeySource $key)
    {
        $this->key = $key;
    }

    /**
     * Return the current key instance.
     *
     * @return KeySource instance
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Encrypt the value provided with the current key and the Defuse library.
     *
     * @param string $value Value to encrypt
     * @return string Ciphertext (encrypted) value
     */
    public function encrypt($value)
    {
        // Get the key contents, no sense in keeping it in memory for too long
        $keyAscii = trim($this->key->getContent());
        return DefuseCrypto::encrypt($value, DefuseKey::loadFromAsciiSafeString($keyAscii));
    }

    /**
     * Decrypt the ciphertext value provided
     * This method also catches values that may not be encrypted
     * and returns them normally.
     *
     * @param string $value Ciphertext (encrypted) string
     * @return mixed The value if it could be decrypted, otherwse null
     */
    public function decrypt($value)
    {
        try {
            $keyAscii = trim($this->key->getContent());
            $value = DefuseCrypto::decrypt($value, DefuseKey::loadFromAsciiSafeString($keyAscii));

            return $value;
        } catch (\Defuse\Crypto\Exception\CryptoException $e) {
            // The value probably wasn't encrypted, move along...
            return null;
        }
    }
}
