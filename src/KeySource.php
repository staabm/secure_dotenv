<?php

namespace staabm\SecureDotenv;

abstract class KeySource
{
    /**
     * Content of the key.
     *
     * @var string
     */
    protected string $content;

    /**
     * Get the current key contents.
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set the current key content.
     *
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
