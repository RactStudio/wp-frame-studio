<?php

namespace RactStudio\FrameStudio\Contracts;

/**
 * Contract for accessing global WP options safely.
 */
interface SettingsRepositoryInterface
{
    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Set a setting value.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function set($key, $value);

    /**
     * Check if a setting exists.
     *
     * @param string $key
     * @return bool
     */
    public function has($key);

    /**
     * Delete a setting.
     *
     * @param string $key
     * @return bool
     */
    public function delete($key);

    /**
     * Get all settings.
     *
     * @return array
     */
    public function all();
}

