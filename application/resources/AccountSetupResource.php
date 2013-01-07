<?php

class AccountSetupResource extends AppResource {
    public $next;

    public function pre_execute() {
        $this->next = isset($_GET['return']) ? $_GET['return'] : $_SERVER['REQUEST_URI'];

        if(null === AuthenticationService::$singleton->user) {
            return $this->smart_redirect('/login?return=' . urlencode($this->next));
        }

        if(!AuthenticationService::$singleton->user->isVerified()) {
            return new UserRequiresEmailVerificationResponse($this);
        }

        if(AuthenticationService::$singleton->user->isAccountSetup()) {
            return $this->smart_redirect('/account');
        }

        return true;
    }

    public function execute() {
        if($this->request->post) {
            $validator = new UserSetupValidator();

            $data = $this->request->data;

            $errors = $validator->validate($data);

            if(!empty($errors)) {
                return $this->generic_error($errors);
            }

            $userModel = AuthenticationService::$singleton->user;

            $userModel->extend($data);
            $userModel->updatePassword($data['password']);
            $userModel->is_setup = true;

            UserUpdaterService::$singleton->saveUserModel($userModel);

            return $this->smart_redirect('/account');
        }

        return new AppViewResponse($this, array(
            'view' => 'AccountSetupPage',
            'variables' => array(
                'user' => AuthenticationService::$singleton->user
            )
        ));
    }
}