<?php /** @var CampaignModel $campaign */ ?>
<div id="campaignPage">
    <h2><?= htmlspecialchars($campaign->getDisplayName()) ?></h2>
    <div>
        <form id="donationForm" action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_xclick" />
            <input type="hidden" name="business" value="<?= htmlspecialchars($campaign->paypal_address) ?>" />
            <input type="hidden" name="item_name" value="Donation" />
            <input type="hidden" name="button_subtype" value="products" />
            <input type="hidden" name="custom" value="<?= $donation_id ?>" />
            <input type="hidden" name="notify_url" value="http://streamdonate.com/ipn" />
            <input type="hidden" name="return" value="http://streamdonate.com/comment/<?= $donation_id ?>" />
            <input id="donationButton" type="button" name="checkout" value="<?= htmlspecialchars(lang_get('donate_button_label')) ?>" />
        </form>
    </div>
    <p><?= htmlspecialchars($campaign->description) ?></p>
    <div style="<?= empty($page_html) ? 'display:none' : '' ?>">
        <?= $page_html ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var enabled = true;

        $('#donationButton').click(function() {
            if(!enabled) {
                return;
            }

            enabled = false;

            $.post('/sd/<?= $donation_id ?>/<?= $campaign->short_url ?>', function() {
                $('#donationForm').submit();
            });
        });
    });
</script>