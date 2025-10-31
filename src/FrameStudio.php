<?php

namespace RactStudio\FrameStudio;

use RactStudio\FrameStudio\Hooks\HooksLoader;

/**
 * Main entry class for the FrameStudio Composer package.
 * Does not directly execute WordPress code — only bootstraps submodules.
 */
class FrameStudio
{
    public static function hooks(): HooksLoader
    {
        return new HooksLoader();
    }
}