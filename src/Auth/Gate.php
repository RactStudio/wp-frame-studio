<?php

namespace RactStudio\FrameStudio\Auth;

class Gate
{
    /**
     * Determine if the given capability is allowed for the current user.
     *
     * @param  string  $capability
     * @param  mixed  $arguments
     * @return bool
     */
    public function allows($capability, $arguments = [])
    {
        return current_user_can($capability, ...((array) $arguments));
    }

    /**
     * Determine if the given capability is denied for the current user.
     *
     * @param  string  $capability
     * @param  mixed  $arguments
     * @return bool
     */
    public function denies($capability, $arguments = [])
    {
        return ! $this->allows($capability, $arguments);
    }
}
