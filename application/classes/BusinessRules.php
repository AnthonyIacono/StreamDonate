<?php

class BusinessRules extends Extendable {
    /**
     * @var BusinessRules
     */
    public static $singleton = null;

    public static function changeSingleton(BusinessRules $s) {
        self::$singleton = $s;
    }

    public $supported_languages = array(
        'english' => 'English',
        'japanese_utf8' => 'Japanese'
    );

    public $default_bg_color = 'ffffff';
    public $default_text_color = '000000';
    public $default_font_size = '12';

    public $supported_timezones = array(
        'America/Adak' => '(GMT-10:00) Hawaii-Aleutian Standard Time',
        'America/Nome' => '(GMT-9:00) Alaska Standard Time',
        'America/Los_Angeles' => '(GMT-8:00) Pacific Standard Time',
        'America/Boise' => '(GMT-7:00) Mountain Standard Time',
        'America/Belize' => '(GMT-6:00) Central Standard Time',
        'America/Atikokan' => '(GMT-5:00) Eastern Standard Time',
        'America/Caracas' => '(GMT-4:30) Venezuela Time',
        'America/Anguilla' => '(GMT-4:00) Atlantic Standard Time',
        'America/St_Johns' => '(GMT-3:30) Newfoundland Standard Time',
        'America/Araguaina' => '(GMT-3:00) Brasilia Time',
        'Brazil/DeNoronha' => '(GMT-2:00) Fernando de Noronha Time',
        'Atlantic/Azores' => '(GMT-1:00) Azores Time',
        'Africa/Abidjan' => '(GMT+0:00) Greenwich Mean Time',
        'Africa/Algiers' => '(GMT+1:00) Central European Time',
        'Africa/Cairo' => '(GMT+2:00) Eastern European Time',
        'Africa/Asmara' => '(GMT+3:00) Eastern African Time',
        'Asia/Dubai' => '(GMT+4:00) Gulf Standard Time',
        'Asia/Kabul' => '(GMT+4:30) Afghanistan Time',
        'Asia/Karachi' => '(GMT+5:00) Pakistan Time',
        'Asia/Colombo' => '(GMT+5:30) India Standard Time',
        'Asia/Katmandu' => '(GMT+5:45) Nepal Time',
        'Indian/Chagos' => '(GMT+6:00) Indian Ocean Territory Time',
        'Indian/Cocos' => '(GMT+6:30) Cocos Islands Time',
        'Asia/Bangkok' => '(GMT+7:00) Indochina Time',
        'Antarctica/Casey' => '(GMT+8:00) Western Standard Time (Australia)',
        'Asia/Chongqing' => '(GMT+8:00) China Standard Time',
        'Australia/Eucla' => '(GMT+8:45) Central Western Standard Time (Australia)',
        'Asia/Tokyo' => '(GMT+9:00) Japan Standard Time',
        'Australia/Darwin' => '(GMT+9:30) Central Standard Time (Northern Territory)',
        'Australia/NSW' => '(GMT+10:00) Eastern Standard Time (New South Wales)',
        'Australia/Lord_Howe' => '(GMT+10:30) Lord Howe Standard Time',
        'Asia/Magadan' => '(GMT+11:00) Magadan Time',
        'Antarctica/South_Pole' => '(GMT+12:00) New Zealand Standard Time'
    );

    public $translator_groups = array(2);
}

if(BusinessRules::$singleton === null) {
    BusinessRules::changeSingleton(new BusinessRules());
}