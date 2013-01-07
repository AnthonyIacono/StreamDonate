<?php

class BrokenLinkResponse extends AppViewResponse {
    public $status = 404;

    public function __construct(AppResource $resource, $properties = array()) {
        parent::__construct($resource, $properties);

        $this->view = 'BrokenLinkPage';

        if($resource->request->async) {
            $this->layout = 'ajax';
        }
    }
}