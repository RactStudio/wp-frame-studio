<?php

namespace RactStudio\FrameStudio\Auth;

class AuthManager
{
    /**
     * Get the currently authenticated user.
     *
     * @return \WP_User|false
     */
    public function user()
    {
        return wp_get_current_user();
    }

    /**
     * Check if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return is_user_logged_in();
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        return get_current_user_id() ?: null;
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param  array  $credentials
     * @param  bool  $remember
     * @return \WP_User|false|\WP_Error
     */
    public function attempt(array $credentials = [], $remember = false)
    {
        $creds = [
            'user_login'    => $credentials['email'] ?? $credentials['username'],
            'user_password' => $credentials['password'],
            'remember'      => $remember,
        ];

        return wp_signon($creds);
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout()
    {
        wp_logout();
    }
}
