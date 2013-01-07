<?php

class UserUpdaterService extends Extendable {
    /**
     * @var UserUpdaterService
     */
    public static $singleton = null;

    public static function changeSingleton(UserUpdaterService $s) {
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

    /**
     * @var MySQLTable
     */
    public $user_preferences;

    public function __construct($properties = array()) {
        parent::__construct($properties);

        $this->database = MySQLPool::$singleton->database(Config::$Configs['mysql']);

        $this->users = $this->database->table('users');
        $this->user_preferences = $this->database->table('user_preferences');
    }

    public function saveUserModel(UserModel $model) {
        $this->users->save($model);
    }

    public function saveUserPreferencesModel(UserPreferencesModel $model) {
        $this->user_preferences->save($model);
    }
}

if(UserUpdaterService::$singleton === null) {
    UserUpdaterService::changeSingleton(new UserUpdaterService());
}