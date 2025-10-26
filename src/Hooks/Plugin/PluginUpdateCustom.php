<?php

namespace RactStudio\FrameStudio\Hooks\Plugin;

/**
 * Handles custom update flows (e.g., private servers, GitHub, SaaS APIs).
 */
class PluginUpdateCustom extends BasePluginHook
{
    protected static string $eventName = 'framestudio/plugin/custom_updated';

    /**
     * Register the custom update hook.
     * Developers can trigger this manually or from custom update services.
     *
     * @param string $mainFile
     */
    public static function register(string $mainFile): void
    {
        // No automatic hook — developers trigger this manually.
        // Example: do_action('framestudio/plugin/custom_update', $slug, $data);
        add_action('framestudio/plugin/custom_update', [static::class, 'handle'], 10, 2);
    }

    /**
     * Handle custom update callback.
     *
     * @param string $slug
     * @param mixed $response
     */
    public static function handle(string $slug, $response): void
    {
        // error_log('[FrameStudio] Custom plugin update handled for ' . $slug);

        static::dispatch([
            'slug' => $slug,
            'response' => $response,
            'time' => time(),
        ]);
    }
}
