<?php

class NewUserPreferencesModel extends UserPreferencesModel {
    public function asSavableModel() {
        $savable = (array)$this;

        unset($savable['id']);

        return $savable;
    }
}