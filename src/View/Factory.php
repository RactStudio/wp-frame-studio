<?php

namespace RactStudio\FrameStudio\View;

use Exception;

class Factory
{
    /**
     * The array of view paths.
     *
     * @var array
     */
    protected $paths;

    /**
     * Data shared across all views.
     *
     * @var array
     */
    protected $shared = [];

    /**
     * Create a new view factory instance.
     *
     * @param  array|string  $paths
     * @param  array  $options  (Unused, kept for backward compat signature if needed)
     * @return void
     */
    public function __construct($paths, $options = [])
    {
        $this->paths = (array) $paths;
    }

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string  $view
     * @param  array  $data
     * @return string
     */
    public function make($view, $data = [])
    {
        return $this->render($view, $data);
    }

    /**
     * Render the given view.
     *
     * @param  string  $view
     * @param  array  $data
     * @return string
     * @throws \Exception
     */
    public function render($view, $data = [])
    {
        $path = $this->find($view);
        
        $data = array_merge($this->shared, $data);
        
        // Render in a clean scope
        return $this->evaluatePath($path, $data);
    }
    
    /**
     * Get the evaluated contents of the view.
     *
     * @param  string  $path
     * @param  array   $data
     * @return string
     */
    protected function evaluatePath($path, $data)
    {
        $obLevel = ob_get_level();

        ob_start();

        extract($data, EXTR_SKIP);

        try {
            include $path;
        } catch (Exception $e) {
            $this->handleViewException($e, $obLevel);
        } catch (\Throwable $e) {
            $this->handleViewException(new Exception($e->getMessage(), 0, $e), $obLevel);
        }

        return ob_get_clean();
    }
    
    /**
     * Handle a view exception.
     *
     * @param  \Exception  $e
     * @param  int  $obLevel
     * @return void
     *
     * @throws \Exception
     */
    protected function handleViewException(Exception $e, $obLevel)
    {
        while (ob_get_level() > $obLevel) {
            ob_end_clean();
        }

        throw $e;
    }

    /**
     * Find the view file.
     *
     * @param  string  $view
     * @return string
     * @throws \Exception
     */
    protected function find($view)
    {
        $view = str_replace('.', '/', $view);
        
        foreach ($this->paths as $path) {
            // Check for .php files (native)
            $file = rtrim($path, '/') . '/' . $view . '.php';
            if (file_exists($file)) {
                return $file;
            }
        }
        
        throw new Exception("View [{$view}] not found.");
    }
    
    /**
     * Add a path to the loader.
     * 
     * @param string $path
     */
    public function addPath($path)
    {
        $this->paths[] = $path;
    }
    
    /**
     * Share data with all views.
     *
     * @param  array|string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function share($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            $this->shared[$key] = $value;
        }

        return $value;
    }
}
