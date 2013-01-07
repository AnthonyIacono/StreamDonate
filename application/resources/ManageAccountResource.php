<?php

class ManageAccountResource extends ProtectedResource {
    public function execute() {

        if($this->request->post) {
            $data = $this->request->data;

            $validator = new ManageUserValidator();

            $errors = $validator->validate($data);

            if(!empty($errors)) {
                return $this->generic_error($errors);
            }

            $userModel = AuthenticationService::$singleton->user;

            $userModel->extend($data);
            UserUpdaterService::$singleton->saveUserModel($userModel);

            return $this->smart_redirect('/account');
        }

        return new AppViewResponse($this, array(
            'view' => 'ManageAccountPage',
            'variables' => array(
                'user' => AuthenticationService::$singleton->user
            )
        ));
    }
}