<?php

namespace RactStudio\FrameStudio\WordPress;

class Taxonomy
{
    /**
     * The taxonomy name.
     *
     * @var string
     */
    protected $name;

    /**
     * The object types (post types) this taxonomy applies to.
     *
     * @var array|string
     */
    protected $objectTypes;

    /**
     * The taxonomy arguments.
     *
     * @var array
     */
    protected $args = [];

    /**
     * Create a new Taxonomy instance.
     *
     * @param  string  $name
     * @param  array|string  $objectTypes
     * @return void
     */
    public function __construct($name, $objectTypes)
    {
        $this->name = $name;
        $this->objectTypes = $objectTypes;
    }

    /**
     * Create and register a new taxonomy.
     *
     * @param  string  $name
     * @param  array|string  $objectTypes
     * @param  array  $args
     * @return static
     */
    public static function register($name, $objectTypes, $args = [])
    {
        $instance = new static($name, $objectTypes);
        $instance->args = $args;
        
        add_action('init', function() use ($instance) {
            register_taxonomy($instance->name, $instance->objectTypes, $instance->args);
        });

        return $instance;
    }
}
