<?php

namespace RactStudio\FrameStudio\Queue;

use RactStudio\FrameStudio\Contracts\QueueInterface;

/**
 * Manages queue connections and job dispatching.
 */
class QueueManager
{
    /**
     * The queue connections.
     *
     * @var array
     */
    protected $connections = [];

    /**
     * The default queue connection.
     *
     * @var string
     */
    protected $defaultConnection = 'default';

    /**
     * Create a new queue manager instance.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->defaultConnection = $config['default'] ?? 'default';
    }

    /**
     * Get a queue connection.
     *
     * @param string|null $connection
     * @return QueueInterface
     */
    public function connection($connection = null)
    {
        $connection = $connection ?? $this->defaultConnection;

        if (!isset($this->connections[$connection])) {
            $this->connections[$connection] = $this->createConnection($connection);
        }

        return $this->connections[$connection];
    }

    /**
     * Create a queue connection.
     *
     * @param string $connection
     * @return QueueInterface
     */
    protected function createConnection($connection)
    {
        // For now, we'll use a simple WordPress-based queue
        // This can be extended to support database, Redis, etc.
        return new Connections\WordPressConnection();
    }

    /**
     * Push a new job onto the queue.
     *
     * @param Job|string $job
     * @param mixed $data
     * @param string|null $queue
     * @return mixed
     */
    public function push($job, $data = '', $queue = null)
    {
        return $this->connection()->push($job, $data, $queue);
    }

    /**
     * Push a new job onto the queue after a delay.
     *
     * @param \DateTimeInterface|\DateInterval|int $delay
     * @param Job|string $job
     * @param mixed $data
     * @param string|null $queue
     * @return mixed
     */
    public function later($delay, $job, $data = '', $queue = null)
    {
        return $this->connection()->later($delay, $job, $data, $queue);
    }
}

