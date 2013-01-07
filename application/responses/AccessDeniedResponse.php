<?php

class AccessDeniedResponse extends AppViewResponse {
    public $status = 403;

    public function __construct(AppResource $resource, $properties = array()) {
        parent::__construct($resource, $properties);

        $this->view = 'AccessDeniedPage';

        if($resource->request->async) {
            $this->layout = 'ajax';
        }
    }
}