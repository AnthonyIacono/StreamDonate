<?php

class CampaignModel extends AppModel {
    public $id;
    public $user_id;
    public $display_name;
    public $short_url;
    public $description;
    public $goal_usd;
    public $total_usd;
    public $ends_datetime;
    public $page_html;

    /**
     * @var UserModel
     */
    public $user_model;

    /**
     * @static
     * @param $row
     * @return CampaignModel
     */
    public static function modelBinder($row) {
        $model = new CampaignModel($row);

        $model->user_model = RougeModelBinder::$singleton->bindModelFromPrefixedMembers($model, 'u_', 'UserModel');

        return $model;
    }

    public function getDisplayName($language = null) {
        return $this->display_name;
    }
}