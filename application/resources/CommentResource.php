<?php

class CommentResource extends AppResource {
    public function execute() {
        /**
         * @var DonationModel $donationModel
         */
        $donationModel = ViewQueryFactory::$singleton->getDonationModelById($this->route->named['donation_id']);

        if(null === $donationModel) {
            return new NotFoundResponse($this);
        }

        if($this->request->post) {
            $comment = $this->request->getData('comment');

            if(empty($comment)) {
                return $this->generic_error(array(
                    'comment' => array(
                        lang_get('comment_required_error')
                    )
                ));
            }

            $donationModel->comment = $comment;

            DonationProcessingService::$singleton->saveDonationModel($donationModel);

            $location_js = json_encode('/c/' . $donationModel->campaign_model->short_url);

            return $this->generic_dialog(lang_get('comment_success_title'), lang_get('comment_success_message'), null, <<<JS
document.location = {$location_js};
JS
            );
        }

        return new AppViewResponse($this, array(
            'view' => 'CommentPage',
            'variables' => array(
                'donation' => $donationModel
            )
        ));
    }
}