<?php

class UpdatePasswordValidator extends SimpleValidator {
    public function __construct(UserModel $userModel) {
        parent::__construct(array(
            'current_password' => array(
                'required' => true,
                'required_message' => lang_get('update_password_current_password_required_error'),
                'custom' => array(
                    array(
                        'function' => function($current_password) use($userModel) {
                            return StrLib::Hash($current_password) == $userModel->password;
                        },
                        'message' => lang_get('update_password_current_password_incorrect_error')
                    )
                )
            ),
            'new_password' => array(
                'required' => true,
                'required_message' => lang_get('update_password_new_password_required_error'),
                'min_length' => 6,
                'min_length_message' => lang_get('update_password_new_password_min_length_error')
            ),
            'confirm_new_password' => array(
                'required' => true,
                'required_message' => lang_get('update_password_confirm_new_password_required_error'),
                'custom' => array(
                    array(
                        'function' => function($confirm_new_password, $data) {
                            return $data['new_password'] == $confirm_new_password;
                        },
                        'message' => lang_get('update_password_passwords_must_match_error')
                    )
                )
            )
        ));
    }
}