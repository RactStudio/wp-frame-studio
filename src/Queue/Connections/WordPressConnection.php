<?php

namespace RactStudio\FrameStudio\Queue\Connections;

use RactStudio\FrameStudio\Contracts\QueueInterface;
use RactStudio\FrameStudio\Queue\Job;

/**
 * WordPress-based queue connection using wp_schedule_single_event.
 */
class WordPressConnection implements QueueInterface
{
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
        if ($job instanceof Job) {
            $jobData = serialize($job);
        } else {
            $jobData = serialize(['job' => $job, 'data' => $data]);
        }

        // Store job in options table
        $jobId = 'queue_job_' . uniqid();
        update_option($jobId, $jobData, false);

        // Schedule immediate execution via WP Cron
        wp_schedule_single_event(time(), 'wp_frame_studio_process_queue', [$jobId]);

        return $jobId;
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
        if (is_int($delay)) {
            $timestamp = time() + $delay;
        } elseif ($delay instanceof \DateTimeInterface) {
            $timestamp = $delay->getTimestamp();
        } else {
            // DateInterval - approximate conversion
            $timestamp = time() + $delay->s;
        }

        if ($job instanceof Job) {
            $jobData = serialize($job);
        } else {
            $jobData = serialize(['job' => $job, 'data' => $data]);
        }

        $jobId = 'queue_job_' . uniqid();
        update_option($jobId, $jobData, false);

        wp_schedule_single_event($timestamp, 'wp_frame_studio_process_queue', [$jobId]);

        return $jobId;
    }

    /**
     * Pop the next job off of the queue.
     *
     * @param string|null $queue
     * @return Job|null
     */
    public function pop($queue = null)
    {
        // This would be called by the queue processor
        // For now, return null as WordPress handles this via cron
        return null;
    }
}

