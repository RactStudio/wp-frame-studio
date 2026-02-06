<?php

namespace RactStudio\FrameStudio\Support;

class Env
{
    /**
     * The environment repository instance.
     *
     * @var \RactStudio\FrameStudio\Config\Repository
     */
    protected static $repository;

    /**
     * Get the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        // For now, we rely on $_ENV or getenv() which phpdotenv populates.
        // In a full implementation, we might want a repository.
        
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        if ($value === false) {
            return $default instanceof \Closure ? $default() : $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
            return $matches[2];
        }

        return $value;
    }
}
