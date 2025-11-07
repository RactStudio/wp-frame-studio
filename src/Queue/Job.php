<?php

namespace RactStudio\FrameStudio\Queue;

/**
 * Base class for asynchronous, dispatchable background tasks.
 */
abstract class Job
{
    /**
     * The job ID.
     *
     * @var string
     */
    public $id;

    /**
     * The number of times the job has been attempted.
     *
     * @var int
     */
    public $attempts = 0;

    /**
     * The maximum number of attempts.
     *
     * @var int
     */
    public $maxAttempts = 3;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->id = uniqid('job_', true);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    abstract public function handle();

    /**
     * Handle a job failure.
     *
     * @param \Throwable $exception
     * @return void
     */
    public function failed(\Throwable $exception)
    {
        // Override in child classes if needed
    }

    /**
     * Get the number of times the job has been attempted.
     *
     * @return int
     */
    public function attempts()
    {
        return $this->attempts;
    }

    /**
     * Determine if the job has been attempted too many times.
     *
     * @return bool
     */
    public function hasFailed()
    {
        return $this->attempts >= $this->maxAttempts;
    }
}

