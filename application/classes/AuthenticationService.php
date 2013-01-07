<?php

class AuthenticationService extends Extendable {
    const CREDENTIALS_OK = 0;
    const CREDENTIALS_USER_NOT_FOUND = 1;
    const CREDENTIALS_INCORRECT_PASSWORD = 2;
    const CREDENTIALS_INVALID_EMAIL_ADDRESS = 3;
    const CREDENTIALS_USER_NOT_SETUP = 4;

    /**
     * @var AuthenticationService
     */
    public static $singleton = null;

    public static function changeSingleton(AuthenticationService $s) {
        self::$singleton = $s;
    }

    /**
     * @var UserModel
     */
    public $user = null;

    public function __construct($properties = array()) {
        @session_start();

        parent::__construct($properties);

        $this->database = MySQLPool::$singleton->database(Config::$Configs['mysql']);

        $logged_in_user_id = $this->getLoggedInUserId();

        if($logged_in_user_id !== null) {
            $this->user = ViewQueryFactory::$singleton->getUserModelById($logged_in_user_id);
        }
    }

    public function getLoggedInUserId() {
        if(empty($_SESSION['logged_in_user_id'])) {
            return null;
        }

        $user_id = (int)$_SESSION['logged_in_user_id'];

        if($user_id <= 0) {
            return null;
        }

        return $user_id;
    }

    public function login($user_id) {
        $_SESSION['logged_in_user_id'] = $user_id;
        $this->user = ViewQueryFactory::$singleton->getUserModelById($user_id);
    }

    public function logout() {
        $_SESSION['logged_in_user_id'] = 0;
        $this->user = null;
    }

    public function checkCredentials($email, $password, &$userModelOutput) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return AuthenticationService::CREDENTIALS_INVALID_EMAIL_ADDRESS;
        }

        if(empty($password)) {
            return AuthenticationService::CREDENTIALS_INCORRECT_PASSWORD;
        }

        /**
         * @var UserModel $userModel
         */
        $userModel = ViewQueryFactory::$singleton->getUserModelByEmailAddress($email);

        $userModelOutput = $userModel;

        if (null === $userModel) {
            return AuthenticationService::CREDENTIALS_USER_NOT_FOUND;
        }

        if(!$userModel->isAccountSetup()) {
            return AuthenticationService::CREDENTIALS_USER_NOT_SETUP;
        }

        if ($userModel->password != StrLib::Hash($password)) {
            return AuthenticationService::CREDENTIALS_INCORRECT_PASSWORD;
        }

        return AuthenticationService::CREDENTIALS_OK;
    }
}

if(AuthenticationService::$singleton === null) {
    AuthenticationService::changeSingleton(new AuthenticationService());
}