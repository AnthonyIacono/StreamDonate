<?php

class VerificationResource extends AppResource {
    public function execute() {
        $user_id = empty($_GET['user_id']) ? '' : $_GET['user_id'];
        $verification_hash = empty($_GET['verification_hash']) ? '' : $_GET['verification_hash'];

        /**
         * @var UserModel $userModel
         */
        $userModel = ViewQueryFactory::$singleton->getUserModelById($user_id);

        if($userModel === null || $userModel->verification_hash != $verification_hash) {
            return new BrokenLinkResponse($this);
        }

        if(!empty($userModel->email_verify)) {
            $verifyUserCheck = ViewQueryFactory::$singleton->getUserModelByEmailAddress($userModel->email_verify);

            if(null !== $verifyUserCheck) {
                return new BrokenLinkResponse($this);
            }

            EmailVerificationService::$singleton->verifyUserEmail($userModel);
        }

        if(!$userModel->isAccountSetup()) {
            AuthenticationService::$singleton->login($userModel->id);

            return $this->smart_redirect('/account/setup');
        }

        return $this->smart_redirect('/account');
    }
}