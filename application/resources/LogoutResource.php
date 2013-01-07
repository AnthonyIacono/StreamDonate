<?php

class LogoutResource extends AppResource {
    public $next;

    public function __construct($properties = array()) {
        parent::__construct($properties);

        $this->next = isset($_GET['return']) ? $_GET['return'] : '/';
    }

    public function execute() {
        AuthenticationService::$singleton->logout();

        return $this->smart_redirect($this->next);
    }
}