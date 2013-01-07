<?php
/** @var UserModel $user */
?>
<form aj="1" action="<?= $this->resource->request->uri ?>" method="POST">
    <div class="contentBox">
        <div class="contentBoxHeader">
            <?= htmlspecialchars(lang_get('account_setup_password_header')) ?>
        </div>

        <div class="contentBoxBody">
            <label>
                <?= htmlspecialchars(lang_get('account_setup_password_textbox_label')) ?>
                <?= $this->element('passwordbox', array(
                    'name' => 'password',
                    'value' => ''
                )) ?>
            </label><br />
            <label>
                <?= htmlspecialchars(lang_get('account_setup_confirm_password_textbox_label')) ?>
                <?= $this->element('passwordbox', array(
                    'name' => 'confirm_password',
                    'value' => ''
                )) ?>
            </label><br />
        </div>
    </div>

    <div class="contentBox">
        <div class="contentBoxHeader">
            <?= htmlspecialchars(lang_get('account_setup_information_header')) ?>
        </div>

        <div class="contentBoxBody">
                <label>
                    <?= htmlspecialchars(lang_get('account_setup_first_name_textbox_label')) ?>
                    <?= $this->element('textbox', array(
                        'name' => 'first_name',
                        'value' => $user->first_name
                    )) ?>
                </label><br />

                <label>
                    <?= htmlspecialchars(lang_get('account_setup_last_name_textbox_label')) ?>
                    <?= $this->element('textbox', array(
                        'name' => 'last_name',
                        'value' => $user->last_name
                    )) ?>
                </label><br />

                <label>
                    <?= htmlspecialchars(lang_get('account_setup_first_name_kanji_textbox_label')) ?>
                    <?= $this->element('textbox', array(
                        'name' => 'first_name_kanji',
                        'value' => $user->first_name_kanji
                    )) ?>
                </label><br />

                <label>
                    <?= htmlspecialchars(lang_get('account_setup_last_name_kanji_textbox_label')) ?>
                    <?= $this->element('textbox', array(
                        'name' => 'last_name_kanji',
                        'value' => $user->last_name_kanji
                    )) ?>
                </label><br />

                <label>
                   <?= htmlspecialchars(lang_get('account_setup_company_name_textbox_label')) ?>
                   <?= $this->element('textbox', array(
                       'name' => 'company_name',
                       'value' => $user->company_name
                    )) ?>
                </label><br />

                <input type="submit" value="<?= htmlspecialchars(lang_get('account_setup_save_information_button_label')) ?>" />
        </div>
    </div>
</form>