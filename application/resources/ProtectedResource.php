<?php

class ProtectedResource extends AppResource {
    public function pre_execute() {
        if(null === AuthenticationService::$singleton->user) {
            return $this->smart_redirect('/login?return=' . urlencode($_SERVER['REQUEST_URI']));
        }

        if(!AuthenticationService::$singleton->user->isVerified()) {
            return new UserRequiresEmailVerificationResponse($this);
        }

        if(!AuthenticationService::$singleton->user->isAccountSetup()) {
            return $this->smart_redirect('/account/setup?return=' . urlencode($_SERVER['REQUEST_URI']));
        }

        return true;
    }
}