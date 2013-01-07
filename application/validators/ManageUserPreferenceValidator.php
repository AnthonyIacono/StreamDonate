<?php

class ManageUserPreferenceValidator extends SimpleValidator {
    public $illegal_fields = array('id', 'user_id');

    public function __construct($rules = array()) {
        $validator_rules = array(
            'language' => array(
                'required' => false,
                'validate_when_empty' => true,
                'custom' => array(
                    array(
                        'function' => function($language) {
                            return in_array($language, array_keys(BusinessRules::$singleton->supported_languages));
                        },
                        'message' => lang_get('preference_validator_invalid_language_message')
                    )
                )
            ),
            'timezone' => array(
                'required' => false,
                'validate_when_empty' => true,
                'custom' => array(
                    array(
                        'function' => function($timezone) {
                            return in_array($timezone, array_keys(BusinessRules::$singleton->supported_timezones));
                        },
                        'message' => lang_get('preference_validator_invalid_timezone_message')
                    )
                )
            )
        );

        $rules = array_merge($validator_rules, (array)$rules);

        parent::__construct($rules);
    }
}