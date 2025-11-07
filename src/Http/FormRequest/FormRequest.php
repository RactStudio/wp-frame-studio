<?php

namespace RactStudio\FrameStudio\Http\FormRequest;

use RactStudio\FrameStudio\Http\WpRequest;
use RactStudio\FrameStudio\Http\Security\Authorizer;
use RactStudio\FrameStudio\Http\Security\Sanitizer;

/**
 * Base class for defining authorization and validation rules for requests.
 */
abstract class FormRequest extends WpRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Sanitize the request data.
     *
     * @return array
     */
    public function validated()
    {
        $data = $this->all();

        // Apply sanitization based on rules
        foreach ($this->rules() as $field => $rules) {
            if (isset($data[$field])) {
                $data[$field] = $this->sanitizeField($data[$field], $rules);
            }
        }

        return $data;
    }

    /**
     * Sanitize a field based on rules.
     *
     * @param mixed $value
     * @param string|array $rules
     * @return mixed
     */
    protected function sanitizeField($value, $rules)
    {
        if (is_string($rules)) {
            $rules = explode('|', $rules);
        }

        foreach ($rules as $rule) {
            $value = $this->applySanitizationRule($value, $rule);
        }

        return $value;
    }

    /**
     * Apply a sanitization rule.
     *
     * @param mixed $value
     * @param string $rule
     * @return mixed
     */
    protected function applySanitizationRule($value, $rule)
    {
        switch ($rule) {
            case 'email':
                return Sanitizer::email($value);
            case 'url':
                return Sanitizer::url($value);
            case 'key':
                return Sanitizer::key($value);
            case 'textarea':
                return Sanitizer::textarea($value);
            default:
                if (is_string($value)) {
                    return Sanitizer::text($value);
                }
                return $value;
        }
    }

    /**
     * Get all input from the request.
     *
     * @return array
     */
    public function all()
    {
        return array_merge(parent::all(), $this->input());
    }
}

