<?php

namespace RactStudio\FrameStudio\Http\Security;

/**
 * Utility for checking user capabilities/permissions.
 */
class Authorizer
{
    /**
     * Check if the current user has a capability.
     *
     * @param string $capability
     * @param int|null $objectId
     * @return bool
     */
    public static function can($capability, $objectId = null)
    {
        if ($objectId !== null) {
            return current_user_can($capability, $objectId);
        }

        return current_user_can($capability);
    }

    /**
     * Check if the current user is logged in.
     *
     * @return bool
     */
    public static function isAuthenticated()
    {
        return is_user_logged_in();
    }

    /**
     * Check if the current user is an administrator.
     *
     * @return bool
     */
    public static function isAdmin()
    {
        return current_user_can('manage_options');
    }

    /**
     * Check if the current user can edit posts.
     *
     * @param int|null $postId
     * @return bool
     */
    public static function canEditPost($postId = null)
    {
        if ($postId !== null) {
            return current_user_can('edit_post', $postId);
        }

        return current_user_can('edit_posts');
    }

    /**
     * Check if the current user can delete posts.
     *
     * @param int|null $postId
     * @return bool
     */
    public static function canDeletePost($postId = null)
    {
        if ($postId !== null) {
            return current_user_can('delete_post', $postId);
        }

        return current_user_can('delete_posts');
    }

    /**
     * Get the current user ID.
     *
     * @return int
     */
    public static function userId()
    {
        return get_current_user_id();
    }

    /**
     * Get the current user.
     *
     * @return \WP_User|null
     */
    public static function user()
    {
        return wp_get_current_user();
    }
}

