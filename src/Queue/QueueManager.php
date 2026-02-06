<?php

namespace RactStudio\FrameStudio\Queue;

class QueueManager
{
    /**
     * Push a new job onto the queue.
     *
     * @param  string|object  $job
     * @param  mixed  $data
     * @return mixed
     */
    public function push($job, $data = '')
    {
        // Simple WP Cron Wrapper for now
        // In real app, we might use DB table or Redis
        
        $jobClass = is_object($job) ? get_class($job) : $job;
        
        if (! wp_next_scheduled($jobClass, [$data])) {
            wp_schedule_single_event(time(), $jobClass, [$data]);
        }
    }
    
    /**
     * Handle a WP Cron event.
     * 
     * @param string $jobClass
     * @param mixed $data
     */
    public function handleCron($jobClass, $data)
    {
        if (class_exists($jobClass)) {
            $job = new $jobClass($data);
            if (method_exists($job, 'handle')) {
                $job->handle();
            }
        }
    }
}
