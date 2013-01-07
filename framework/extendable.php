<?php
/**
 * One of the most useful classes in the entire framework to greatly simplify the task of reflecting state.
 * Oh, and for all the things that Lighter does to ensure you don't have to follow a ton of conventions,
 * don't be a cry-baby about this one.
 */
class Extendable {
    public function __construct($properties = array()) {
        $this->extend($properties);
    }

    public function extend($properties = array()) {
        foreach($properties as $k => $v) {
            $this->{$k} = $v;
        }
    }
}