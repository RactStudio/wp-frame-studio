<?php

namespace RactStudio\FrameStudio\Hooks;

class HookManager
{
    /**
     * The array of actions registered with WordPress.
     *
     * @var array
     */
    protected $actions = [];

    /**
     * The array of filters registered with WordPress.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * @param  string  $hook          The name of the WordPress action that is being registered.
     * @param  object  $component     A reference to the instance of the object on which the action is defined.
     * @param  string  $callback      The name of the function definition on the $component.
     * @param  int     $priority      Optional. The priority at which the function should be fired. Default is 10.
     * @param  int     $acceptedArgs  Optional. The number of arguments that should be passed to the $callback. Default is 1.
     */
    public function addAction($hook, $component, $callback, $priority = 10, $acceptedArgs = 1)
    {
        $this->actions[] = compact('hook', 'component', 'callback', 'priority', 'acceptedArgs');
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @param  string  $hook          The name of the WordPress filter that is being registered.
     * @param  object  $component     A reference to the instance of the object on which the filter is defined.
     * @param  string  $callback      The name of the function definition on the $component.
     * @param  int     $priority      Optional. The priority at which the function should be fired. Default is 10.
     * @param  int     $acceptedArgs  Optional. The number of arguments that should be passed to the $callback. Default is 1.
     */
    public function addFilter($hook, $component, $callback, $priority = 10, $acceptedArgs = 1)
    {
        $this->filters[] = compact('hook', 'component', 'callback', 'priority', 'acceptedArgs');
    }

    /**
     * Register the filters and actions with WordPress.
     */
    public function register()
    {
        foreach ($this->filters as $hook) {
            add_filter($hook['hook'], [$hook['component'], $hook['callback']], $hook['priority'], $hook['acceptedArgs']);
        }

        foreach ($this->actions as $hook) {
            add_action($hook['hook'], [$hook['component'], $hook['callback']], $hook['priority'], $hook['acceptedArgs']);
        }
    }
}
