<?php

namespace RactStudio\FrameStudio\Debug;

/**
 * Tools for benchmarking memory usage and execution time of framework services.
 */
class Profiler
{
    /**
     * The start times.
     *
     * @var array
     */
    protected static $startTimes = [];

    /**
     * The start memory usage.
     *
     * @var array
     */
    protected static $startMemory = [];

    /**
     * Start profiling a section.
     *
     * @param string $name
     * @return void
     */
    public static function start($name)
    {
        self::$startTimes[$name] = microtime(true);
        self::$startMemory[$name] = memory_get_usage(true);
    }

    /**
     * End profiling a section.
     *
     * @param string $name
     * @return array
     */
    public static function end($name)
    {
        if (!isset(self::$startTimes[$name])) {
            return null;
        }

        $duration = microtime(true) - self::$startTimes[$name];
        $memory = memory_get_usage(true) - self::$startMemory[$name];
        $peakMemory = memory_get_peak_usage(true);

        unset(self::$startTimes[$name], self::$startMemory[$name]);

        return [
            'name' => $name,
            'duration' => $duration,
            'memory' => $memory,
            'peak_memory' => $peakMemory,
        ];
    }

    /**
     * Get all profiling results.
     *
     * @return array
     */
    public static function getResults()
    {
        $results = [];

        foreach (self::$startTimes as $name => $startTime) {
            $results[$name] = self::end($name);
        }

        return $results;
    }

    /**
     * Format bytes to human readable format.
     *
     * @param int $bytes
     * @return string
     */
    public static function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}

