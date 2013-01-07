<?php

Lib::Import('models/AppModel');

class UserModel extends AppModel {
    public $id;
    public $email_address;
    public $email_verify;
    public $password;
    public $verification_hash;
    public $display_name;
    public $is_setup;

    /**
     * @var UserPreferencesModel
     */
    public $preferences;

    public function isVerified() {
        return !empty($this->email_address);
    }

    public function isAccountSetup() {
        return !empty($this->is_setup);
    }

    public function updatePassword($newPassword) {
        $this->password = StrLib::Hash($newPassword);
    }

    public function getDisplayName($language = null) {
        return empty($this->display_name) ? $this->email_address : $this->display_name;
    }

    public static function modelBinder($row) {
        $model = new UserModel($row);

        $model->preferences = RougeModelBinder::$singleton->bindModelFromPrefixedMembers($model, 'p_', 'UserPreferencesModel');

        return $model;
    }
}