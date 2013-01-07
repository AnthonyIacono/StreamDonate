<?php

class UpdateEmailResource extends ProtectedResource {
    public function execute() {
        if(!$this->request->post) {
            return new BrokenLinkResponse($this);
        }

        $userModel = AuthenticationService::$singleton->user;

        $newEmailAddress = $this->request->getData('email_address');

        if(!empty($newEmailAddress) && $userModel->email_address == $newEmailAddress) {
            return $this->generic_error(array(
                'email_address' => array(
                    lang_get('manage_account_email_nothing_to_change_error')
                )
            ));
        }

        if(!filter_var($newEmailAddress, FILTER_VALIDATE_EMAIL)) {
            return $this->generic_error(array(
                'email_address' => array(
                    lang_get('manage_account_email_invalid_error')
                )
            ));
        }

        if(null !== ViewQueryFactory::$singleton->getUserModelByEmailAddress($newEmailAddress)) {
            return $this->generic_error(array(
                'email_address' => array(
                    lang_get('manage_account_email_already_in_use_error')
                )
            ));
        }

        $userModel->email_verify = $newEmailAddress;
        $userModel->verification_hash = StrLib::RandomHash();
        UserUpdaterService::$singleton->saveUserModel($userModel);

        return $this->generic_dialog(lang_get('manage_account_settings_updated_dialog_title'),
            sprintf(lang_get('manage_account_email_updated_requires_verification'), $newEmailAddress), null,
            ViewRenderingService::$singleton->renderView('ManageAccountEmailUpdateTransition',
                array('email_address' => $newEmailAddress, 'old_email_address' => $userModel->email_address)));
    }
}