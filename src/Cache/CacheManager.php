<?php

namespace RactStudio\FrameStudio\Cache;

use RactStudio\FrameStudio\Contracts\CacheInterface;

/**
 * Resolves and manages different cache stores.
 */
class CacheManager
{
    /**
     * The cache drivers.
     *
     * @var array
     */
    protected $drivers = [];

    /**
     * The default cache driver.
     *
     * @var string
     */
    protected $defaultDriver = 'transient';

    /**
     * Create a new cache manager instance.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->defaultDriver = $config['default'] ?? 'transient';
    }

    /**
     * Get a cache driver instance.
     *
     * @param string|null $driver
     * @return CacheInterface
     */
    public function driver($driver = null)
    {
        $driver = $driver ?? $this->defaultDriver;

        if (!isset($this->drivers[$driver])) {
            $this->drivers[$driver] = $this->createDriver($driver);
        }

        return $this->drivers[$driver];
    }

    /**
     * Create a cache driver instance.
     *
     * @param string $driver
     * @return CacheInterface
     */
    protected function createDriver($driver)
    {
        switch ($driver) {
            case 'transient':
                return new Drivers\TransientDriver();
            default:
                throw new \InvalidArgumentException("Cache driver [{$driver}] is not supported.");
        }
    }

    /**
     * Store an item in the cache.
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $ttl
     * @return bool
     */
    public function put($key, $value, $ttl = null)
    {
        return $this->driver()->put($key, $value, $ttl);
    }

    /**
     * Retrieve an item from the cache.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->driver()->get($key, $default);
    }

    /**
     * Remove an item from the cache.
     *
     * @param string $key
     * @return bool
     */
    public function forget($key)
    {
        return $this->driver()->forget($key);
    }

    /**
     * Remove all items from the cache.
     *
     * @return bool
     */
    public function flush()
    {
        return $this->driver()->flush();
    }

    /**
     * Determine if an item exists in the cache.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return $this->driver()->has($key);
    }
}

