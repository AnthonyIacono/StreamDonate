<?php

class CampaignResource extends AppResource {
    public function execute() {
        $campaign = ViewQueryFactory::$singleton->getCampaignModelByShortUrl($this->route->named['short_url']);

        if(null === $campaign) {
            return new NotFoundResponse($this);
        }

        $page_html = '';

        if(!empty($campaign->page_html)) {
            $page_html = str_replace('{total_usd}', '$' . number_format($campaign->total_usd, 2), $campaign->page_html);
            $page_html = str_replace('{goal_usd}', '$' . number_format($campaign->goal_usd, 2), $page_html);
        }

        return new AppViewResponse($this, array(
            'view' => 'CampaignPage',
            'variables' => array(
                'campaign' => $campaign,
                'page_html' => $page_html,
                'donation_id' => StrLib::Guid()
            )
        ));
    }
}