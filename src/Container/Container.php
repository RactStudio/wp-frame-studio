<?php

namespace RactStudio\FrameStudio\Container;

use Closure;
use Exception;
use ReflectionClass;

class Container
{
    /**
     * The current globally available container (if any).
     *
     * @var static
     */
    protected static $instance;

    /**
     * The container's bindings.
     *
     * @var array
     */
    protected $bindings = [];

    /**
     * The container's shared instances.
     *
     * @var array
     */
    protected $instances = [];

    /**
     * Set the globally available instance of the container.
     *
     * @param  static|null  $container
     * @return static|null
     */
    public static function setInstance(Container $container = null)
    {
        return static::$instance = $container;
    }

    /**
     * Get the globally available instance of the container.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Register a binding with the container.
     *
     * @param  string  $abstract
     * @param  \Closure|string|null  $concrete
     * @param  bool  $shared
     * @return void
     */
    public function bind($abstract, $concrete = null, $shared = false)
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        $this->bindings[$abstract] = compact('concrete', 'shared');
    }

    /**
     * Register a shared binding in the container.
     *
     * @param  string  $abstract
     * @param  \Closure|string|null  $concrete
     * @return void
     */
    public function singleton($abstract, $concrete = null)
    {
        $this->bind($abstract, $concrete, true);
    }

    /**
     * Resolve the given type from the container.
     *
     * @param  string  $abstract
     * @return mixed
     *
     * @throws \Exception
     */
    public function make($abstract)
    {
        return $this->resolve($abstract);
    }

    /**
     * Resolve the given type from the container.
     *
     * @param  string  $abstract
     * @return mixed
     */
    protected function resolve($abstract)
    {
        // 1. Return singleton if exists
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        // 2. Check if bound
        if (! isset($this->bindings[$abstract])) {
            // If not bound, try to instantiate directly if class exists
            if (class_exists($abstract)) {
                return $this->build($abstract);
            }
            throw new Exception("Service not found: {$abstract}");
        }

        $concrete = $this->bindings[$abstract]['concrete'];
        $object = $this->build($concrete);

        // 3. Cache if singleton
        if ($this->bindings[$abstract]['shared']) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    /**
     * Instantiate a concrete instance.
     *
     * @param  \Closure|string  $concrete
     * @return mixed
     */
    protected function build($concrete)
    {
        if ($concrete instanceof Closure) {
            return $concrete($this);
        }

        try {
            $reflector = new ReflectionClass($concrete);
        } catch (Exception $e) {
             throw new Exception("Target class [$concrete] does not exist.", 0, $e);
        }

        if (! $reflector->isInstantiable()) {
            throw new Exception("Target [$concrete] is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        // If no constructor, just return new instance
        if (is_null($constructor)) {
            return new $concrete;
        }

        $dependencies = $constructor->getParameters();
        $instances = $this->resolveDependencies($dependencies);

        return $reflector->newInstanceArgs($instances);
    }

    /**
     * Resolve dependencies for the instance.
     *
     * @param  array  $dependencies
     * @return array
     */
    protected function resolveDependencies($dependencies)
    {
        $results = [];

        foreach ($dependencies as $dependency) {
            if ($dependency->hasType() && ! $dependency->getType()->isBuiltin()) {
                $results[] = $this->make($dependency->getType()->getName());
            } else {
                 if ($dependency->isDefaultValueAvailable()) {
                    $results[] = $dependency->getDefaultValue();
                } else {
                     throw new Exception("Unresolvable dependency resolving [$dependency] in class {$dependency->getDeclaringClass()->getName()}");
                }
            }
        }

        return $results;
    }
    
    /**
     * Determine if the given abstract type has been bound.
     *
     * @param  string  $abstract
     * @return bool
     */
    public function bound($abstract)
    {
        return isset($this->bindings[$abstract]) || isset($this->instances[$abstract]);
    }
}
