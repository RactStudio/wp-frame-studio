<?php

namespace RactStudio\FrameStudio\Security;

class SecurityManager
{
    /**
     * Verify a nonce.
     *
     * @param  string  $nonce
     * @param  string|int  $action
     * @return int|false
     */
    public function verifyNonce($nonce, $action = -1)
    {
        return wp_verify_nonce($nonce, $action);
    }

    /**
     * Create a nonce.
     *
     * @param  string|int  $action
     * @return string
     */
    public function createNonce($action = -1)
    {
        return wp_create_nonce($action);
    }

    /**
     * Sanitize a text field.
     *
     * @param  string  $str
     * @return string
     */
    public function sanitize($str)
    {
        return sanitize_text_field($str);
    }
}
