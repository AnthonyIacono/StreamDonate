<?php

class SpawnDonationResource extends AppResource {
    public function execute() {
        if(!$this->request->post) {
            return new BrokenLinkResponse($this);
        }

        $donationId = $this->route->named['donation_id'];
        $shortUrl = $this->route->named['short_url'];

        /**
         * @var CampaignModel $campaignModel
         */
        $campaignModel = ViewQueryFactory::$singleton->getCampaignModelByShortUrl($shortUrl);

        if(!StrLib::IsGuid($donationId) || null === $campaignModel) {
            return new BrokenLinkResponse($this);
        }

        $donations = $this->database->table('donations');

        $donations->save(new DonationModel(array(
            'id' => $donationId,
            'campaign_id' => $campaignModel->id
        )));

        return new Response();
    }
}