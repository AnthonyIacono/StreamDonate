<?php

Lib::Import(array('mysql/mysql_table'));

class MySQLFluentSelectQuery extends Extendable {
    public $data = array();

    public function __construct($properties = array()) {
        parent::__construct($properties);

        if(!isset($this->data['tables'])) {
            $this->data['tables'] = array();
        }

        if(!isset($this->data['where'])) {
            $this->data['where'] = array();
        }

        if(!isset($this->data['joins'])) {
            $this->data['joins'] = array();
        }

        if(!isset($this->data['columns'])) {
            $this->data['columns'] = array();
        }
    }

    /**
     * @param $table_or_shortname
     * @param $column_name
     * @param null $as_identifier
     * @return MySQLFluentSelectQuery
     */
    public function column($table_or_shortname, $column_name, $as_identifier = null) {
        $table_or_shortname = is_object($table_or_shortname) ? $table_or_shortname->table : $table_or_shortname;

        $this->data['columns'][] = array(
            'table_or_shortname' => $table_or_shortname,
            'column_name' => $column_name,
            'as_identifier' => $as_identifier
        );

        return $this;
    }

    /**
     * @param MySQLTable $table
     * @param null $as_prefix
     * @param null $as_suffix
     * @return MySQLFluentSelectQuery
     */
    public function allColumns(MySQLTable $table, $as_prefix = null, $as_suffix = null) {
        /**
         * @var MySQLFieldSchema $fieldSchema
         */
        foreach($table->schema as $fieldSchema) {
            $as_identifier = null;

            if($as_prefix !== null) {
                $as_identifier = $as_prefix . $fieldSchema->Field;
            }

            if($as_suffix !== null) {
                $as_identifier = $as_identifier === null ?
                    $fieldSchema->Field . $as_suffix :
                    $as_identifier . $as_suffix;
            }

            $this->column($table, $fieldSchema->Field, $as_identifier);
        }

        return $this;
    }

    /**
     * @param $table
     * @param null $shortname
     * @return MySQLFluentSelectQuery
     * @throws Exception
     */
    public function from($table, $shortname = null) {
        if(!is_string($table)) {
            if(!is_a($table, 'MySQLTable')) {
                throw new Exception('Table must be a string or a MySQLTable class');
            }

            $table = $table->table;
        }

        $duplicateFound = false;

        foreach($this->data['tables'] as $tableData) {
            if($tableData['table'] != $table && $shortname !== null && $tableData['shortname'] === $shortname) {
                throw new Exception('You may not use the same shortname for two different tables.');
            }

            if($tableData['table'] != $table) {
                continue;
            }

            if($shortname !== $tableData['shortname']) {
                continue;
            }

            $duplicateFound = true;
            break;
        }

        if(!$duplicateFound) {
            $this->data['tables'][] = array(
                'table' => $table,
                'shortname' => $shortname
            );
        }

        return $this;
    }

    /**
     * @param $tablename
     * @param null $shortname
     * @param string $direction
     * @param array $conditions
     * @return MySQLFluentSelectQuery
     */
    public function join($tablename, $shortname = null, $direction = 'left', $conditions = array()) {
        $this->data['joins'][] = array(
            'direction' => $direction,
            'tablename' => $tablename,
            'shortname' => $shortname,
            'conditions' => $conditions
        );

        return $this;
    }

    /**
     * @param array $conditions
     * @param string $logic_operator (!!important!! only used if not the first where call)
     * @return MySQLFluentSelectQuery
     */
    public function where($conditions = array(), $logic_operator = 'and') {
        $this->data['where'][] = array(
            'conditions' => $conditions,
            'logic_operator' => $logic_operator
        );

        return $this;
    }
}