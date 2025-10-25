<?php

namespace FrameStudio\Hooks;

use FrameStudio\Hooks\Plugin\{
    PluginActivate, PluginDeactivate, PluginUninstall,
    PluginUpdate, PluginUpdateCustom
};

use FrameStudio\Hooks\Theme\{
    ThemeActivate, ThemeDeactivate, ThemeUninstall,
    ThemeUpdate, ThemeUpdateCustom
};

/**
 * Centralized loader for plugin and theme hook registration.
 * Supports class overrides for full developer customization.
 */
class HooksLoader
{
    /**
     * Register plugin-related hooks.
     *
     * @param string $mainFile The main plugin file.
     * @param array  $overrides Optional map of class overrides.
     */
    public function registerPluginHooks(string $mainFile, array $overrides = []): void
    {
        $this->registerHooks('Plugin', $mainFile, $overrides);
    }

    /**
     * Register theme-related hooks.
     *
     * @param array $overrides Optional map of class overrides.
     */
    public function registerThemeHooks(array $overrides = []): void
    {
        $this->registerHooks('Theme', null, $overrides);
    }

    /**
     * Internal hook registration logic.
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
            $fqcn = "\\FrameStudio\\Hooks\\{$type}\\{$hookClass}";

            // Allow developer override via $overrides array
            if (isset($overrides[$hookClass]) && class_exists($overrides[$hookClass])) {
                $fqcn = $overrides[$hookClass];
            }

            if (class_exists($fqcn) && method_exists($fqcn, 'register')) {
                $fqcn::register($mainFile);
            }
        }
    }
}
