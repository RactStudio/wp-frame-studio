<?php

namespace FrameStudio\Hooks\Plugin;

/**
 * Handles updates from WordPress.org or normal plugin update flow.
 */
class PluginUpdate extends BasePluginHook
{
    protected static string $eventName = 'framestudio/plugin/updated';

    /**
     * Register the update hook.
     *
     * @param string $mainFile
     */
    public static function register(string $mainFile): void
    {
        add_action('upgrader_process_complete', [static::class, 'handle'], 10, 2);
    }

    /**
     * Called after plugin update is completed.
     *
     * @param \WP_Upgrader $upgrader
     * @param array $options
     */
    public static function handle($upgrader, array $options): void
    {
        if (empty($options['type']) || $options['type'] !== 'plugin') {
            return;
        }

        if (isset($options['plugins']) && is_array($options['plugins'])) {
            foreach ($options['plugins'] as $plugin) {
                error_log('[FrameStudio] Plugin updated: ' . $plugin);
            }
        }

        static::dispatch([
            'type' => $options['type'] ?? 'unknown',
            'plugins' => $options['plugins'] ?? [],
            'time' => time(),
        ]);
    }
}
