<?php

namespace staabm\SecureDotenv;

abstract class KeySource
{
    /**
     * Content of the key.
     */
    protected string $content;

    /**
     * Get the current key contents.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set the current key content.
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
