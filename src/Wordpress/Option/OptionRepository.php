<?php

namespace RactStudio\FrameStudio\Wordpress\Option;

use RactStudio\FrameStudio\Contracts\SettingsRepositoryInterface;

/**
 * Implements SettingsRepositoryInterface for safe, type-safe access to WP Options.
 */
class OptionRepository implements SettingsRepositoryInterface
{
    /**
     * The option prefix.
     *
     * @var string
     */
    protected $prefix = 'wp_frame_studio_';

    /**
     * Create a new option repository instance.
     *
     * @param string|null $prefix
     */
    public function __construct($prefix = null)
    {
        if ($prefix) {
            $this->prefix = $prefix;
        }
    }

    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $value = get_option($this->prefix . $key, $default);

        return $value !== false ? $value : $default;
    }

    /**
     * Set a setting value.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function set($key, $value)
    {
        return update_option($this->prefix . $key, $value);
    }

    /**
     * Check if a setting exists.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return get_option($this->prefix . $key) !== false;
    }

    /**
     * Delete a setting.
     *
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        return delete_option($this->prefix . $key);
    }

    /**
     * Get all settings.
     *
     * @return array
     */
    public function all()
    {
        global $wpdb;

        $options = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name LIKE %s",
                $wpdb->esc_like($this->prefix) . '%'
            ),
            ARRAY_A
        );

        $settings = [];
        foreach ($options as $option) {
            $key = str_replace($this->prefix, '', $option['option_name']);
            $settings[$key] = maybe_unserialize($option['option_value']);
        }

        return $settings;
    }
}

