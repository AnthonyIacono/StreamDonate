<?php

class EmailVerificationService extends Extendable {
    /**
     * @var EmailVerificationService
     */
    public static $singleton = null;

    public static function changeSingleton(EmailVerificationService $s) {
        self::$singleton = $s;
    }

    /**
     * @var MySQLDatabase
     */
    public $database;

    /**
     * @var MySQLTable
     */
    public $users;

    public function __construct($properties = array()) {
        parent::__construct($properties);

        $this->database = MySQLPool::$singleton->database(Config::$Configs['mysql']);
        $this->users = $this->database->table('users');
    }

    public function verifyUserEmail(UserModel $userModel) {
        $userModel->email_address = $userModel->email_verify;
        $userModel->email_verify = null;

        UserUpdaterService::$singleton->saveUserModel($userModel);
    }
}

if(EmailVerificationService::$singleton === null) {
    EmailVerificationService::changeSingleton(new EmailVerificationService());
}