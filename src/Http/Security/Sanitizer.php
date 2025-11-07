<?php

namespace RactStudio\FrameStudio\Http\Security;

/**
 * Centralized Input Sanitization utility for common data types.
 */
class Sanitizer
{
    /**
     * Sanitize text field.
     *
     * @param string $value
     * @return string
     */
    public static function text($value)
    {
        return sanitize_text_field($value);
    }

    /**
     * Sanitize textarea field.
     *
     * @param string $value
     * @return string
     */
    public static function textarea($value)
    {
        return sanitize_textarea_field($value);
    }

    /**
     * Sanitize email.
     *
     * @param string $value
     * @return string
     */
    public static function email($value)
    {
        return sanitize_email($value);
    }

    /**
     * Sanitize URL.
     *
     * @param string $value
     * @return string
     */
    public static function url($value)
    {
        return esc_url_raw($value);
    }

    /**
     * Sanitize key.
     *
     * @param string $value
     * @return string
     */
    public static function key($value)
    {
        return sanitize_key($value);
    }

    /**
     * Sanitize file name.
     *
     * @param string $value
     * @return string
     */
    public static function fileName($value)
    {
        return sanitize_file_name($value);
    }

    /**
     * Sanitize HTML.
     *
     * @param string $value
     * @param array $allowedHtml
     * @return string
     */
    public static function html($value, array $allowedHtml = [])
    {
        return wp_kses($value, $allowedHtml ?: wp_kses_allowed_html('post'));
    }

    /**
     * Sanitize SQL.
     *
     * @param string $value
     * @return string
     */
    public static function sql($value)
    {
        return esc_sql($value);
    }

    /**
     * Sanitize attribute.
     *
     * @param string $value
     * @return string
     */
    public static function attribute($value)
    {
        return esc_attr($value);
    }

    /**
     * Sanitize for JS output.
     *
     * @param string $value
     * @return string
     */
    public static function js($value)
    {
        return esc_js($value);
    }

    /**
     * Sanitize array of values.
     *
     * @param array $values
     * @param callable $callback
     * @return array
     */
    public static function array(array $values, callable $callback = null)
    {
        if ($callback === null) {
            $callback = [self::class, 'text'];
        }

        return array_map($callback, $values);
    }
}

