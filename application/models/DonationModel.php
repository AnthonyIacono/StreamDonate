<?php

class DonationModel extends AppModel {
    public $id;
    public $campaign_id;
    public $payment_data;
    public $payment_datetime;
    public $comment;

    /**
     * @var CampaignModel
     */
    public $campaign_model;

    /**
     * @static
     * @param $row
     * @return DonationModel
     */
    public static function modelBinder($row) {
        $model = new DonationModel($row);

        $model->campaign_model = RougeModelBinder::$singleton->bindModelFromPrefixedMembers($model, 'c_', 'CampaignModel');

        return $model;
    }
}