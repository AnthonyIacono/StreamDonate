<?php
/** @var UserModel $user */
?>
<h2><?= htmlspecialchars(lang_get('manage_account_header')) ?></h2>

<div class="contentBox">
    <a href="/account/preferences"><?= lang_get('manage_account_preferences_link_label') ?></a>
</div>

<div class="contentBox">
    <div class="contentBoxHeader">
        <?= htmlspecialchars(lang_get('manage_account_information_header')) ?>
    </div>

    <div class="contentBoxBody">
        <form aj="1" action="<?= $this->resource->request->uri ?>" method="POST">
            <label>
               <?= htmlspecialchars(lang_get('manage_account_display_name_textbox_label')) ?>
               <?= $this->element('textbox', array(
                   'name' => 'display_name',
                   'value' => $user->display_name
                )) ?>
            </label><br />

            <input type="submit" value="<?= htmlspecialchars(lang_get('manage_account_update_information_button_label')) ?>" />
        </form>
    </div>
</div>

<div class="contentBox">
    <div class="contentBoxHeader">
        <?= htmlspecialchars(lang_get('manage_account_email_address_header')) ?>
    </div>

    <div class="contentBoxBody">
        <form aj="1" action="/account/update-email" method="POST">
            <label>
                <?= htmlspecialchars(lang_get('manage_account_email_address_textbox_label')) ?>
                <?= $this->element('textbox', array(
                    'name' => 'email_address',
                    'default' => lang_get('manage_account_email_address_textbox_default'),
                    'value' => $user->email_address
                )) ?>
            </label><br />
            
            <p id="emailAddressPendingVerificationLabel" style="display: <?= empty($user->email_verify) ? 'none' : 'block' ?>">
                <?= htmlspecialchars(lang_get('manage_account_email_address_pending_verification_label')) ?>
                <span id="emailAddressPendingVerification"><?= htmlspecialchars($user->email_verify) ?></span><br />
                <i><?= htmlspecialchars(lang_get('manage_account_email_address_pending_verification_explanation')) ?></i>
                <a aj="1" method="POST" href="/account/resend-verification"><?= htmlspecialchars(lang_get('manage_account_resend_verification_link_label')) ?></a>
            </p>

            <input type="submit" value="<?= htmlspecialchars(lang_get('manage_account_update_email_address_button_label')) ?>" />
        </form>
    </div>
</div>

<div class="contentBox">
    <div class="contentBoxHeader">
        <?= htmlspecialchars(lang_get('manage_account_update_password_header')) ?>
    </div>

    <div class="contentBoxBody">
        <form aj="1" action="/account/update-password" method="POST">
            <label>
                <?= htmlspecialchars(lang_get('manage_account_current_password_textbox_label')) ?>
                <?= $this->element('passwordbox', array(
                    'name' => 'current_password',
                    'value' => ''
                )) ?>
            </label><br />

            <label>
                <?= htmlspecialchars(lang_get('manage_account_new_password_textbox_label')) ?>
                <?= $this->element('passwordbox', array(
                    'name' => 'new_password',
                    'value' => ''
                )) ?>
            </label><br />

            <label>
                <?= htmlspecialchars(lang_get('manage_account_confirm_password_textbox_label')) ?>
                <?= $this->element('passwordbox', array(
                    'name' => 'confirm_new_password',
                    'value' => ''
                )) ?>
            </label><br />

            <input type="submit" value="<?= htmlspecialchars(lang_get('manage_account_update_password_button_label')) ?>" />
        </form>
    </div>
</div>