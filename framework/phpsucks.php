<?php

class PhpSucks {
    private function __construct() {

    }

    /**
     * @param $input
     * @return array
     */
    public static function ToIndexBasedArray($input) {
        $output = array();

        if(!is_array($input) && !is_object($input)) {
            return $output;
        }

        foreach($input as $i) {
            $output[] = $i;
        }

        return $output;
    }

    public static function IsAssocArray($arr) {
        if(!is_array($arr)) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    /**
     * @static
     * Flatten an array a single level.
     * @param $arr
     * @return array
     */
    public static function Flatten($arr) {
        $output = array();
        foreach($arr as $_ => $v) {
            if(!is_array($v)) {
                $output[] = $v;
                continue;
            }

            foreach($v as $_ => $v2) {
                $output[] = $v2;
            }
        }
        return $output;
    }
}