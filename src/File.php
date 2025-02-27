<?php

namespace staabm\SecureDotenv;

use InvalidArgumentException;
use RuntimeException;

use function is_array;

class File
{
    public static function read(string $path): array
    {
        $realpath = realpath($path);
        if (false == $realpath || !is_file($path)) {
            throw new InvalidArgumentException('Invalid path: ' . $path);
        }

        $results = parse_ini_file($realpath, true);
        if (false === $results) {
            $lastError = error_get_last();

            throw new RuntimeException('Could not parse ini file: ' . ($lastError['message'] ?? 'Unknown error'));
        }

        return $results;
    }

    /**
     * @param string|array $data
     *
     * @return ($path is null ? void : bool)
     */
    public static function write($data, ?string $path = null)
    {
        $output = '';
        foreach ($data as $index => $data) {
            // See if it's a section
            if (is_array($data)) {
                $output .= '[' . $index . ']';
                foreach ($data as $i => $d) {
                    $output .= $i . '=' . $d . "\n";
                }
                $output .= "\n";
            } else {
                $output .= $index . '=' . $data . "\n";
            }
        }

        if (null !== $path) {
            return file_put_contents($path, $output);
        }
        echo $output;
    }
}
