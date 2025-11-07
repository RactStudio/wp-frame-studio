<?php

namespace RactStudio\FrameStudio\Contracts;

/**
 * Contract for file system operations (Flysystem abstraction).
 */
interface StorageInterface
{
    /**
     * Check if a file exists.
     *
     * @param string $path
     * @return bool
     */
    public function exists($path);

    /**
     * Get the contents of a file.
     *
     * @param string $path
     * @return string|false
     */
    public function get($path);

    /**
     * Write the contents of a file.
     *
     * @param string $path
     * @param string|resource $contents
     * @param array $options
     * @return bool
     */
    public function put($path, $contents, array $options = []);

    /**
     * Delete a file.
     *
     * @param string|array $paths
     * @return bool
     */
    public function delete($paths);

    /**
     * Copy a file to a new location.
     *
     * @param string $from
     * @param string $to
     * @return bool
     */
    public function copy($from, $to);

    /**
     * Move a file to a new location.
     *
     * @param string $from
     * @param string $to
     * @return bool
     */
    public function move($from, $to);

    /**
     * Get the file size.
     *
     * @param string $path
     * @return int
     */
    public function size($path);

    /**
     * Get the file's last modification time.
     *
     * @param string $path
     * @return int
     */
    public function lastModified($path);

    /**
     * Get the URL for the file at the given path.
     *
     * @param string $path
     * @return string
     */
    public function url($path);
}

