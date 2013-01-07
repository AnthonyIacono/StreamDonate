<?php

class UpdatePasswordResource extends AppResource {
    public function execute() {
        if(!$this->request->post) {
            return new BrokenLinkResponse($this);
        }

        $userModel = AuthenticationService::$singleton->user;

        $data = $this->request->data;

        $validator = new UpdatePasswordValidator($userModel);

        $errors = $validator->validate($data);

        if(!empty($errors)) {
            return $this->generic_error($errors);
        }

        $userModel->updatePassword($data['new_password']);

        UserUpdaterService::$singleton->saveUserModel($userModel);

        return $this->generic_dialog(lang_get('manage_account_settings_updated_dialog_title'),
            lang_get('manage_account_password_updated'), null,
            ViewRenderingService::$singleton->renderView('PasswordUpdatedTransition'));
    }
}