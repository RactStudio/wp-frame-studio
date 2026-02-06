<?php

namespace RactStudio\FrameStudio\View;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Factory
{
    /**
     * The Twig Environment instance.
     *
     * @var \Twig\Environment
     */
    protected $twig;

    /**
     * Create a new view factory instance.
     *
     * @param  string|array  $path
     * @param  array  $options
     * @return void
     */
    public function __construct($path, $options = [])
    {
        $loader = new FilesystemLoader($path);
        $this->twig = new Environment($loader, $options);
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
     */
    public function render($view, $data = [])
    {
        // Normalize view name (dot notation to slashes)
        $view = str_replace('.', '/', $view) . '.twig';
        
        return $this->twig->render($view, $data);
    }
    
    /**
     * Add a path to the loader.
     * 
     * @param string $path
     * @param string $namespace
     */
    public function addPath($path, $namespace = FilesystemLoader::MAIN_NAMESPACE)
    {
        $this->twig->getLoader()->addPath($path, $namespace);
    }
}
