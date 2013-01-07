<style type="text/css">
    #userRequiresEmailVerificationContentBox {
        width: 480px;
        margin: 0 auto;
        text-align: center;
    }
</style>
<div id="userRequiresEmailVerificationPage" data-href="<?= $this->resource->request->uri ?>">
    <div id="userRequiresEmailVerificationContentBox">
        <div class="contentBoxHeader">
            <?= htmlspecialchars(lang_get('resource_user_requires_email_verification_title')) ?>
        </div>
        <div class="contentBoxBody">
            <p class="red"><?= htmlspecialchars(lang_get('resource_user_requires_email_verification_subtitle')) ?></p>
            <div class="contentBoxDivider">&nbsp;</div>
            <p><?= htmlspecialchars(lang_get('resource_user_requires_email_verification_paragraph')) ?></p>
        </div>
    </div>
</div>