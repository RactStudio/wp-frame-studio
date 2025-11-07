<?php

namespace RactStudio\FrameStudio\Cache\Drivers;

use RactStudio\FrameStudio\Contracts\CacheInterface;

/**
 * Concrete cache driver that maps to WordPress Transients.
 */
class TransientDriver implements CacheInterface
{
    /**
     * The prefix for all cache keys.
     *
     * @var string
     */
    protected $prefix = 'wp_frame_studio_';

    /**
     * Retrieve an item from the cache by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $value = get_transient($this->prefix . $key);

        if ($value === false) {
            return $default;
        }

        return $value;
    }

    /**
     * Store an item in the cache.
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $ttl Time to live in seconds
     * @return bool
     */
    public function put($key, $value, $ttl = null)
    {
        // Default to 12 hours if no TTL is specified
        $ttl = $ttl ?? (12 * HOUR_IN_SECONDS);

        return set_transient($this->prefix . $key, $value, $ttl);
    }

    /**
     * Remove an item from the cache.
     *
     * @param string $key
     * @return bool
     */
    public function forget($key)
    {
        return delete_transient($this->prefix . $key);
    }

    /**
     * Remove all items from the cache.
     *
     * @return bool
     */
    public function flush()
    {
        global $wpdb;

        // Delete all transients with our prefix
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
                $wpdb->esc_like('_transient_' . $this->prefix) . '%',
                $wpdb->esc_like('_transient_timeout_' . $this->prefix) . '%'
            )
        );

        return true;
    }

    /**
     * Determine if an item exists in the cache.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return get_transient($this->prefix . $key) !== false;
    }

    /**
     * Retrieve an item from the cache and delete it.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function pull($key, $default = null)
    {
        $value = $this->get($key, $default);
        $this->forget($key);

        return $value;
    }
}

