<?php

class HomeResource extends AppResource {
    public function execute() {
        return $this->smart_redirect('/c/agdq-2013');
    }
}