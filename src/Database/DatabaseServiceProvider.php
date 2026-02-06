<?php

namespace RactStudio\FrameStudio\Database;

use RactStudio\FrameStudio\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('db', function ($app) {
            return new Connection();
        });
        
        $this->app->alias('db', Connection::class);
    }

    public function boot()
    {
        //
    }
}
