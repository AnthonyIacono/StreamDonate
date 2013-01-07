<?php

class ManageAccountPrefResource extends ProtectedResource {
    public function execute() {

        if($this->request->post) {
            $data = $this->request->data;

            $validator = new ManageUserPreferenceValidator();

            $errors = $validator->validate($data);

            if(!empty($errors)) {
                return $this->generic_error($errors);
            }

            $userModel = AuthenticationService::$singleton->user;

            $userModel->preferences->extend($data);

            UserUpdaterService::$singleton->saveUserPreferencesModel($userModel->preferences);

            LanguageLocalizer::$singleton->push_language($userModel->preferences->language);

            return $this->generic_dialog(lang_get('message_box_notice_title'), lang_get('message_box_preferences_updated'), null, <<<JS
document.location.reload();
JS
            );
        }

        return new AppViewResponse($this, array(
            'view' => 'ManageAccountPrefPage',
            'variables' => array(
                'user' => AuthenticationService::$singleton->user
            )
        ));
    }
}