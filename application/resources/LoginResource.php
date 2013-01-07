<?php

class LoginResource extends AppResource {
    public $next;

    public function __construct($properties = array()) {
        parent::__construct($properties);

        $this->next = isset($_GET['return']) ? $_GET['return'] : '/';
    }

    public function pre_execute() {
        if(null !== AuthenticationService::$singleton->user) {
            return $this->smart_redirect($this->next);
        }

        return true;
    }

    public function execute() {
        if ($this->request->post) {
            $email_address = $this->request->getData('email_address');
            $password = $this->request->getData('password');

            /**
             * @var UserModel $userModel
             */
            $credentialsResult = AuthenticationService::$singleton->checkCredentials($email_address, $password, $userModel);

            if($credentialsResult == AuthenticationService::CREDENTIALS_INVALID_EMAIL_ADDRESS) {
                return $this->generic_error(array(
                    'email_address' => array(lang_get('authentication_invalid_email_address'))
                ));
            }

            if($credentialsResult == AuthenticationService::CREDENTIALS_USER_NOT_FOUND) {
                return $this->generic_error(array(
                    'email_address' => array(lang_get('authentication_user_not_found'))
                ));
            }

            if($credentialsResult == AuthenticationService::CREDENTIALS_INCORRECT_PASSWORD) {
                return $this->generic_error(array(
                    'password' => array(lang_get('authentication_incorrect_password'))
                ));
            }

            if($credentialsResult == AuthenticationService::CREDENTIALS_USER_NOT_SETUP) {
                return $this->generic_error(array(
                    'email_address' => array(lang_get('authentication_user_not_setup'))
                ));
            }

            AuthenticationService::$singleton->login($userModel->id);

            return $this->smart_redirect($this->next);
        }

        return new AppViewResponse($this, array(
            'view' => 'LoginPage'
        ));
    }
}