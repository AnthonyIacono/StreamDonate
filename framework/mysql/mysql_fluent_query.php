<?php

class MySQLFluentQuery extends Extendable {
    public $directives;

    /**
     * @param $column
     * @param $value
     * @return MySQLFluentQuery
     */
    public function whereEqual($column, $value) {
        return $this;
    }
}