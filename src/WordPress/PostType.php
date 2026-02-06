<?php

namespace RactStudio\FrameStudio\WordPress;

use RactStudio\FrameStudio\Support\Str;

class PostType
{
    /**
     * The post type name.
     *
     * @var string
     */
    protected $name;

    /**
     * The post type arguments.
     *
     * @var array
     */
    protected $args = [];

    /**
     * Create a new Post Type instance.
     *
     * @param  string  $name
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Create and register a new post type.
     *
     * @param  string  $name
     * @param  callable|array  $options
     * @return static
     */
    public static function register($name, $options = [])
    {
        $instance = new static($name);
        
        if (is_callable($options)) {
            $options($instance);
        } elseif (is_array($options)) {
            $instance->args = $options;
        }
        
        // Hook into WP init
        add_action('init', function() use ($instance) {
            register_post_type($instance->name, $instance->args);
        });

        return $instance;
    }

    /**
     * Set a property on the post type arguments.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->args[$key] = $value;
        return $this;
    }
}
