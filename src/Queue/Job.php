<?php

namespace RactStudio\FrameStudio\Queue;

interface Job
{
    /**
     * fire the job.
     *
     * @return void
     */
    public function handle();
}
