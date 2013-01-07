<?php
/**
 * @var DonationModel $donation
 */
?>
<p><?= htmlspecialchars(lang_get('thanks_for_donation')) ?></p>
<form action="<?= $this->resource->request->uri ?>" aj="1" method="POST">
    <textarea name="comment"></textarea><br />
    <input type="submit" value="Submit Donation Comment" />
</form>