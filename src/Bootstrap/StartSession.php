<?php

namespace RactStudio\FrameStudio\Bootstrap;

use RactStudio\FrameStudio\Foundation\Application;

/**
 * Initializes the SessionManager and loads existing session/flash data.
 */
class StartSession
{
    /**
     * Bootstrap the given application.
     *
     * @param Application $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        // Start the session if it hasn't been started already
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            session_start();
        }

        // Load session manager if available (bound by service provider)
        if ($app->bound('session')) {
            try {
                $session = $app->make('session');
                if (method_exists($session, 'start')) {
                    $session->start();
                }
            } catch (\Exception $e) {
                // Session service not available yet, skip
            }
        }
    }
}

