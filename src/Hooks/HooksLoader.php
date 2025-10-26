<?php

namespace RactStudio\FrameStudio\Hooks;

use RactStudio\FrameStudio\Hooks\Plugin\{
    PluginActivate,
    PluginDeactivate,
    PluginUninstall,
    PluginUpdate,
    PluginUpdateCustom
};

use RactStudio\FrameStudio\Hooks\Theme\{
    ThemeActivate,
    ThemeDeactivate,
    ThemeUninstall,
    ThemeUpdate,
    ThemeUpdateCustom
};

/**
 * Centralized loader for all plugin and theme hooks.
 * Supports:
 *  - Plugin hooks registration
 *  - Theme hooks registration
 *  - Developer overrides
 */
class HooksLoader
{
    /**
     * Register all plugin hooks.
     *
     * @param string $mainFile The main plugin file.
     * @param array $overrides Optional associative array of hook overrides.
     *                         Key: hook class name (e.g., 'PluginActivate')
     *                         Value: fully qualified class name
     */
    public function registerPluginHooks(string $mainFile, array $overrides = []): void
    {
        $this->registerHooks('Plugin', $mainFile, $overrides);
    }

    /**
     * Register all theme hooks.
     *
     * @param array $overrides Optional associative array of hook overrides.
     */
    public function registerThemeHooks(array $overrides = []): void
    {
        $this->registerHooks('Theme', null, $overrides);
    }

    /**
     * Internal hook registration logic.
     *
     * @param string $type 'Plugin' or 'Theme'
     * @param string|null $mainFile
     * @param array $overrides
     */
    private function registerHooks(string $type, ?string $mainFile, array $overrides): void
    {
        $hooks = [
            "{$type}Activate",
            "{$type}Deactivate",
            "{$type}Uninstall",
            "{$type}Update",
            "{$type}UpdateCustom",
        ];

        foreach ($hooks as $hookClass) {

            // Default fully qualified class
            $fqcn = "\\RactStudio\\FrameStudio\\Hooks\\{$type}\\{$hookClass}";

            // Use developer override if provided
            if (isset($overrides[$hookClass]) && class_exists($overrides[$hookClass])) {
                $fqcn = $overrides[$hookClass];
            }

            // Register the hook if class exists and has register() method
            if (class_exists($fqcn) && method_exists($fqcn, 'register')) {
                if ($type === 'Plugin') {
                    $fqcn::register($mainFile);
                } else {
                    $fqcn::register();
                }
            }
        }
    }
}
