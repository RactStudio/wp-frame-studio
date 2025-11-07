<?php

namespace RactStudio\FrameStudio\Debug;

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\JsonResponseHandler;

/**
 * Catches exceptions and uses Whoops for detailed reporting in development.
 */
class ErrorHandler
{
    /**
     * The Whoops instance.
     *
     * @var Run
     */
    protected $whoops;

    /**
     * Create a new error handler instance.
     *
     * @param bool $isDebug
     */
    public function __construct($isDebug = false)
    {
        if ($isDebug && class_exists(Run::class)) {
            $this->whoops = new Run();

            if (wp_is_json_request() || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
                $this->whoops->pushHandler(new JsonResponseHandler());
            } else {
                $this->whoops->pushHandler(new PrettyPageHandler());
            }

            $this->whoops->register();
        } else {
            // Use WordPress default error handling in production
            set_error_handler([$this, 'handleError']);
            set_exception_handler([$this, 'handleException']);
        }
    }

    /**
     * Handle a PHP error.
     *
     * @param int $level
     * @param string $message
     * @param string $file
     * @param int $line
     * @return bool
     */
    public function handleError($level, $message, $file, $line)
    {
        if (!(error_reporting() & $level)) {
            return false;
        }

        error_log(sprintf(
            'WP Frame Studio Error: %s in %s on line %d',
            $message,
            $file,
            $line
        ));

        return true;
    }

    /**
     * Handle an uncaught exception.
     *
     * @param \Throwable $exception
     * @return void
     */
    public function handleException($exception)
    {
        error_log(sprintf(
            'WP Frame Studio Exception: %s in %s on line %d',
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        ));
    }
}

