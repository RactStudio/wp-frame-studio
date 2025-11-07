<?php

namespace RactStudio\FrameStudio\Queue;

/**
 * Maps internal scheduled tasks to the WordPress WP-Cron system.
 */
class Scheduler
{
    /**
     * Schedule a task.
     *
     * @param string $hook
     * @param callable|string $callback
     * @param string $recurrence
     * @param array $args
     * @return bool
     */
    public function schedule($hook, $callback, $recurrence = 'hourly', array $args = [])
    {
        if (!wp_next_scheduled($hook, $args)) {
            return wp_schedule_event(time(), $recurrence, $hook, $args);
        }

        return false;
    }

    /**
     * Unschedule a task.
     *
     * @param string $hook
     * @param array $args
     * @return bool
     */
    public function unschedule($hook, array $args = [])
    {
        $timestamp = wp_next_scheduled($hook, $args);

        if ($timestamp) {
            return wp_unschedule_event($timestamp, $hook, $args);
        }

        return false;
    }

    /**
     * Clear all scheduled tasks for a hook.
     *
     * @param string $hook
     * @return void
     */
    public function clear($hook)
    {
        $crons = _get_cron_array();

        if ($crons) {
            foreach ($crons as $timestamp => $cron) {
                if (isset($cron[$hook])) {
                    unset($crons[$timestamp][$hook]);
                }
            }

            _set_cron_array($crons);
        }
    }
}

