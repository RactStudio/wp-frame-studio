<?php

namespace RactStudio\FrameStudio\Api\Middleware;

use WP_REST_Request;
use WP_REST_Response;
use WP_Error;

/**
 * Base interface/class for API middleware logic.
 */
interface Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param WP_REST_Request $request
     * @param callable $next
     * @return WP_REST_Response|WP_Error
     */
    public function handle(WP_REST_Request $request, callable $next);
}

