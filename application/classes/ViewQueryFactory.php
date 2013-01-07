<?php
/**
 * We are very likely to utilize functions in this class for data access in order to prevent redundant framework code.
 */

class ViewQueryFactory extends Extendable {
    /**
     * @var ViewQueryFactory
     */
    public static $singleton = null;

    public static function changeSingleton(ViewQueryFactory $s) {
        self::$singleton = $s;
    }

    /**
     * @var MySQLDatabase
     */
    public $database;

    /**
     * @var MySQLTable
     */
    public $user_view;

    /**
     * @var MySQLTable
     */
    public $campaign_view;

    /**
     * @param MySQLTable
     */
    public $donation_view;

    public function __construct($properties = array()) {
        parent::__construct($properties);

        $this->database = MySQLPool::$singleton->database(Config::$Configs['mysql']);
        $this->user_view = $this->database->table('user_view');
        $this->campaign_view = $this->database->table('campaign_view');
        $this->donation_view = $this->database->table('donation_view');
    }

    public function getUserModelById($userId) {
        return $this->user_view->firstBy('id', $userId, 'UserModel');
    }

    public function getUserModelByEmailAddress($emailAddress) {
        return $this->user_view->firstBy('email_address', $emailAddress, 'UserModel');
    }

    public function getAllUserModels() {
        return $this->user_view->all('UserModel');
    }

    public function getAllVerifiedUserModels() {
        return $this->database->selectQuery(<<<SQL
SELECT * FROM user_view WHERE `verification_hash` IS NOT NULL AND `verification_hash` != ''
SQL
        , 'UserModel');
    }

    public function getCampaignModelByShortUrl($short_url) {
        $c = $this->campaign_view->firstBy('short_url', $short_url, 'CampaignModel');
        return $c;
    }

    public function getDonationModelById($id) {
        return $this->donation_view->firstBy('id', $id, 'DonationModel');
    }

    public function getUserModelByEmailVerify($emailVerify) {
        if(empty($emailVerify)) {
            return null;
        }

        return $this->user_view->firstBy('email_verify', $emailVerify, 'UserModel');
    }
}

if(ViewQueryFactory::$singleton === null) {
    ViewQueryFactory::changeSingleton(new ViewQueryFactory());
}