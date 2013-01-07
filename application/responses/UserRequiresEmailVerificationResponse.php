<?php

class UserRequiresEmailVerificationResponse extends AppViewResponse {
    public $status = 403;

    public function __construct(AppResource $resource, $properties = array()) {
        parent::__construct($resource, $properties);

        $this->view = 'UserRequiresEmailVerificationPage';

        if($resource->request->async) {
            $this->layout = 'ajax';
        }
    }
}