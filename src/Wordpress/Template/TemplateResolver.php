<?php

namespace RactStudio\FrameStudio\Wordpress\Template;

/**
 * Intercepts WP template loading to map to framework Controllers/Views.
 */
class TemplateResolver
{
    /**
     * The template mappings.
     *
     * @var array
     */
    protected $mappings = [];

    /**
     * Create a new template resolver instance.
     */
    public function __construct()
    {
        $this->registerHooks();
    }

    /**
     * Register WordPress hooks.
     *
     * @return void
     */
    protected function registerHooks()
    {
        add_filter('template_include', [$this, 'resolveTemplate'], 99);
    }

    /**
     * Resolve the template for the current request.
     *
     * @param string $template
     * @return string
     */
    public function resolveTemplate($template)
    {
        // Check if we have a custom mapping for this template
        foreach ($this->mappings as $condition => $callback) {
            if (call_user_func($condition)) {
                return call_user_func($callback, $template);
            }
        }

        return $template;
    }

    /**
     * Map a template condition to a callback.
     *
     * @param callable $condition
     * @param callable $callback
     * @return void
     */
    public function map($condition, $callback)
    {
        $this->mappings[] = [$condition, $callback];
    }
}

