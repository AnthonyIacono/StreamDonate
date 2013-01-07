<h2><?= htmlspecialchars(lang_get('login_header')) ?></h2>
<div class="contentBox">
    <div class="contentBoxHeader">
        <?= htmlspecialchars(lang_get('login_box_header')) ?>
    </div>
    <div class="contentBoxBody">
        <form action="<?= $this->resource->request->uri ?>" aj="1" method="POST">
            <label>
                <?= htmlspecialchars(lang_get('login_box_email_address_textbox_label')) ?>
                <?= $this->element('textbox', array(
                    'name' => 'email_address',
                    'value' => ''
                )) ?>
            </label><br />

            <label>
                <?= htmlspecialchars(lang_get('login_box_password_textbox_label')) ?>
                <?= $this->element('passwordbox', array(
                    'name' => 'password',
                    'value' => ''
                )) ?>
            </label><br />

            <input type="submit" value="<?= htmlspecialchars(lang_get('login_box_submit_button_label')) ?>" />
        </form>
    </div>
</div>