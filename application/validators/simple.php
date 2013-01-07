<?php

class SimpleValidator {
    protected $rules;

    public $illegal_fields = array();
    public $whitelist_fields = null;

    public function __construct($rules) {
        $this->rules = $rules;
    }

    public function validate($data, $invalid_message = 'Invalid data in validator') {
        $data = (array)$data;

        $errors = array();

        foreach($data as $k => $_) {
            if(in_array($k, $this->illegal_fields) ||
                ($this->whitelist_fields !== null && !in_array($k, $this->whitelist_fields))) {
                $errors[$k][] = $invalid_message;
            }
        }

        foreach($this->rules as $field => $rule) {
            $required = isset($rule['required']) && $rule['required'];

            if(!isset($data[$field]) || empty($data[$field])) {
                if($required) {
                    $errors[$field][] = isset($rule['required_message']) ? $rule['required_message'] : "Must not be empty";
                }

                $data[$field] = '';

                if(!isset($rule['validate_when_empty']) || !$rule['validate_when_empty']) {
                    continue;
                }
            }

            $subject = $data[$field];

            if(!is_array($subject) && !is_object($subject)) {
                $sub_length = strlen($subject);

                if(isset($rule['min_length']) && $rule['min_length'] !== false && $sub_length < $rule['min_length']) {
                    $errors[$field][] = isset($rule['min_length_message']) ? $rule['min_length_message'] : "Must be at least {$rule['min_length']} characters";
                }

                if(isset($rule['max_length']) && $rule['max_length'] !== false && $sub_length > $rule['max_length']) {
                    $errors[$field][] = isset($rule['max_length_message']) ? $rule['max_length_message'] : "May not be longer than {$rule['max_length']} characters";
                }

                if(isset($rule['patterns']) && is_array($rule['patterns'])) {
                    foreach($rule['patterns'] as $pattern) {
                        if(!preg_match($pattern['pattern'], $subject)) {
                            $errors[$field][] = isset($pattern['message']) ? $pattern['message'] : 'Malformed';
                        }
                    }
                }
            }

            if(isset($rule['custom']) && is_array($rule['custom'])) {
                foreach($rule['custom'] as $custom) {
                    $custom_fn = $custom['function'];

                    if(!$custom_fn($subject, $data)) {
                        $errors[$field][] = isset($custom['message']) ? $custom['message'] : 'Error';
                    }
                }
            }
        }

        return $errors;
    }
}