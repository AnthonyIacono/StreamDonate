<?php

class NewUserModel extends UserModel {
    public function __construct($properties = array()) {
        parent::__construct($properties);

        $this->preferences = $this->preferences === null ? new UserPreferencesModel() : $this->preferences;
    }

    public function asSavableModel() {
        $savable = (array)$this;

        unset($savable['id']);

        return $savable;
    }
}