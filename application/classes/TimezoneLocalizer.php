<?php

class TimezoneLocalizer extends Extendable {
    /**
     * @var TimezoneLocalizer
     */
    public static $singleton = null;

    public static function changeSingleton(TimezoneLocalizer $s) {
        self::$singleton = $s;
    }

    public $stack = array();

    public function __construct($properties = array()) {
        parent::__construct($properties);

        $this->push_timezone(Config::$Configs['application']['server_timezone']);
    }

    public function push_timezone($timezone) {
        $this->stack[] = $timezone;
    }

    public function get_current_timezone() {
        if(empty($this->stack)) {
            return Config::$Configs['application']['server_timezone'];
        }

        return $this->stack[count($this->stack) - 1];
    }

    public function get_date($format, $timestamp = null, $timezone = null) {
        $timezone = $timezone === null ? $this->get_current_timezone() : $timezone;

        $timestamp = $timestamp === null ? time() : $timestamp;

        $old_timezone = date_default_timezone_get();
        date_default_timezone_set($timezone);
        $result = date($format, $timestamp);
        date_default_timezone_set($old_timezone);

        return $result;
    }

    public function pop_timezone() {
        if(empty($this->stack)) {
            return;
        }

        $this->stack = array_slice($this->stack, 0, count($this->stack) - 1);
    }
}

if(TimezoneLocalizer::$singleton === null) {
    TimezoneLocalizer::changeSingleton(new TimezoneLocalizer());
}

function date_localized($format, $timestamp = null, $timezone = null) {
    return TimezoneLocalizer::$singleton->get_date($format, $timestamp, $timezone);
}