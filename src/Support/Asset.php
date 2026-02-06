<?php

namespace RactStudio\FrameStudio\Support;

class Asset
{
    /**
     * Enqueue a script.
     *
     * @param  string  $handle
     * @param  string  $src
     * @param  array   $deps
     * @param  string|bool|null  $ver
     * @param  bool    $in_footer
     * @return void
     */
    public static function script($handle, $src, $deps = [], $ver = false, $in_footer = true)
    {
        add_action('wp_enqueue_scripts', function() use ($handle, $src, $deps, $ver, $in_footer) {
            wp_enqueue_script($handle, $src, $deps, $ver, $in_footer);
        });
        
        // Also support admin
        add_action('admin_enqueue_scripts', function() use ($handle, $src, $deps, $ver, $in_footer) {
             wp_enqueue_script($handle, $src, $deps, $ver, $in_footer);
        });
    }

    /**
     * Enqueue a style.
     *
     * @param  string  $handle
     * @param  string  $src
     * @param  array   $deps
     * @param  string|bool|null  $ver
     * @param  string  $media
     * @return void
     */
    public static function style($handle, $src, $deps = [], $ver = false, $media = 'all')
    {
        add_action('wp_enqueue_scripts', function() use ($handle, $src, $deps, $ver, $media) {
            wp_enqueue_style($handle, $src, $deps, $ver, $media);
        });
        
         add_action('admin_enqueue_scripts', function() use ($handle, $src, $deps, $ver, $media) {
            wp_enqueue_style($handle, $src, $deps, $ver, $media);
        });
    }
}
