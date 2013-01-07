<?php

class AppViewResponse extends ViewResponse {
    /**
     * @var AppResource
     */
    public $resource;

    public $layout = array('default');

    public function __construct(AppResource $resource, $properties = array()) {
        parent::__construct($properties);

        $this->resource = $resource;
    }

    public function render() {
        //print_r($this->resource->database->benchmarker->getTotalTime() . ' seconds for ' . count($this->resource->database->benchmarker->queries) . ' queries');
        //print_r($this->resource->database->benchmarker->queries);

        parent::render();
    }
}