<?php

class UserValidator extends SimpleValidator {
    public $illegal_fields = array('id', 'password', 'verification_hash', 'is_setup', 'email_address');

    public function __construct($rules = array()) {
        $defaultRules = array(
            'display_name' => array(
                'required' => false
            )
        );

        $rules = array_merge($defaultRules, $rules);

        parent::__construct($rules);
    }
}