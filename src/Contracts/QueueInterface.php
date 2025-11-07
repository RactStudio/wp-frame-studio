<?php

namespace RactStudio\FrameStudio\Contracts;

use RactStudio\FrameStudio\Queue\Job;

/**
 * Contract for dispatching and processing queued jobs.
 */
interface QueueInterface
{
    /**
     * Push a new job onto the queue.
     *
     * @param Job|string $job
     * @param mixed $data
     * @param string|null $queue
     * @return mixed
     */
    public function push($job, $data = '', $queue = null);

    /**
     * Push a new job onto the queue after a delay.
     *
     * @param \DateTimeInterface|\DateInterval|int $delay
     * @param Job|string $job
     * @param mixed $data
     * @param string|null $queue
     * @return mixed
     */
    public function later($delay, $job, $data = '', $queue = null);

    /**
     * Pop the next job off of the queue.
     *
     * @param string|null $queue
     * @return Job|null
     */
    public function pop($queue = null);
}

