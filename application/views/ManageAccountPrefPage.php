<?php
/** @var UserModel $user */
?>
<h2><?= htmlspecialchars(lang_get('manage_account_prefs_header')) ?></h2>

<div class="contentBox">
    <a href="/account"><?= lang_get('manage_account_prefs_account_link_label') ?></a>
</div>

<div class="contentBox">
    <div class="contentBoxHeader">
        <?= htmlspecialchars(lang_get('manage_account_prefs_header')) ?>
    </div>
    <div class="contentBoxBody">
        <form aj="1" action="<?= $this->resource->request->uri ?>" method="POST">
            <label>
                <?= htmlspecialchars(lang_get('manage_account_prefs_language_selectbox_label')) ?>
                <?= $this->element('selectbox', array(
                    'name' => 'language',
                    'value' => $user->preferences->language,
                    'items' => BusinessRules::$singleton->supported_languages
                )) ?>
            </label><br />
            <label>
                <?= htmlspecialchars(lang_get('manage_account_prefs_timezone_selectbox_label')) ?>
                <?= $this->element('selectbox', array(
                    'name' => 'timezone',
                    'value' => $user->preferences->timezone,
                    'items' => BusinessRules::$singleton->supported_timezones
                )) ?>
            </label><br />
            <input type="submit" value="<?= htmlspecialchars(lang_get('manage_account_prefs_update_button_label')) ?>" />
            <input type="button" id="resetPrefsButton" value="<?= htmlspecialchars(lang_get('manage_account_prefs_reset_button_label')) ?>" />
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#resetPrefsButton').click(function() {
            document.location.reload();
            return false;
        });
    });
</script>