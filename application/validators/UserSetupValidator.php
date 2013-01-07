<?php

class UserSetupValidator extends UserValidator {
    public $illegal_fields = array('id', 'verification_hash', 'is_admin', 'email_address');

    public function __construct() {
        parent::__construct(array(
            'password' => array(
                'required' => true,
                'required_message' => lang_get('account_setup_password_required_error'),
                'min_length' => 6,
                'min_length_message' => lang_get('account_setup_password_min_length_error')
            ),
            'confirm_password' => array(
                'required' => true,
                'required_message' => lang_get('account_setup_confirm_password_required_error'),
                'custom' => array(
                    array(
                        'function' => function($confirm_password, $data) {
                            return $data['password'] == $confirm_password;
                        },
                        'message' => lang_get('account_setup_passwords_must_match_error')
                    )
                )
            )
        ));
    }
}