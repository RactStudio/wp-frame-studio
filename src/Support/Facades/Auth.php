<?php

namespace RactStudio\FrameStudio\Support\Facades;

use RactStudio\FrameStudio\Foundation\Facade;

/**
 * @method static \WP_User|false user()
 * @method static bool check()
 * @method static int|null id()
 * @method static \WP_User|false|\WP_Error attempt(array $credentials = [], bool $remember = false)
 * @method static void logout()
 *
 * @see \RactStudio\FrameStudio\Auth\AuthManager
 */
class Auth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'auth';
    }
}
