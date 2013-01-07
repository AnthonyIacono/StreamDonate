<?php

class DonationProcessingService extends Extendable {
    /**
     * @var DonationProcessingService
     */
    public static $singleton = null;

    public static function changeSingleton(DonationProcessingService $s) {
        self::$singleton = $s;
    }

    /**
     * @var MySQLDatabase
     */
    public $database;

    /**
     * @param MySQLTable
     */
    public $donations;

    public function __construct($properties = array()) {
        parent::__construct($properties);
        $this->database = MySQLPool::$singleton->database(Config::$Configs['mysql']);
        $this->donations = $this->database->table('donations');
    }

    public function saveDonationModel(DonationModel $donationModel) {
        $this->donations->save($donationModel);
    }

    public function process(DonationModel $donationModel, $data) {
        $donationModel->payment_datetime = StrLib::DateTime();
        $donationModel->payment_data = json_encode($data);

        $payment_amount = empty($data['mc_gross']) ? 0 : $data['mc_gross'];
        $payment_amount = (float)$payment_amount;

        $this->database->query(<<<SQL
UPDATE `campaigns` SET `total_usd` = `total_usd` + '{$payment_amount}'
SQL
        );

        $this->saveDonationModel($donationModel);
    }
}

if(DonationProcessingService::$singleton === null) {
    DonationProcessingService::changeSingleton(new DonationProcessingService());
}