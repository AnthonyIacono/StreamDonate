<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <?= $this->js('/js/jquery.min.js') ?>
        <?= $this->js('/js/jquery.tools.min.js') ?>
        <?= $this->js('/js/jquery.jscrollpane.min.js') ?>
        <?= $this->js('/js/jquery.cookie.js') ?>
        <?= $this->js('/js/jquery.gOverlay.js') ?>
        <?= $this->js('/js/jquery.mousewheel.js') ?>
        <?= $this->js('/js/textbox.js') ?>
        <?= $this->js('/js/textarea.js') ?>
        <?= $this->js('/js/selectbox.js') ?>
        <?= $this->js('/js/passwordbox.js') ?>
        <?= $this->js('/js/swfobject.js') ?>
        <?= $this->js('/js/jwplayer.js') ?>
        <?= $this->js('/js/form.js') ?>
        <?= $this->js('/js/fileuploader.js') ?>
        <?= $this->js('/js/logic.js') ?>
        <?= $this->js('/js/date.js') ?>
        <?= $this->css('/css/styles.css') ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <div id="header">
            <div class="layout">
                <div class="logo">StreamDonate</div>

                <div id="secondary_navigation">
                    <?php if(!empty(AuthenticationService::$singleton->user->id)) { ?>

                        <a href="/campaigns/manage"><?= htmlspecialchars(lang_get('manage_campaigns_link')) ?></a>
                        <a href="/account"><?= htmlspecialchars(lang_get('manage_account_link')) ?></a>

                    <?php } else { ?>

                        <a href="/login?return=<?= htmlspecialchars(urlencode($this->resource->request->uri)) ?>">
                            <?= htmlspecialchars(lang_get('login_link')) ?>
                        </a>

                    <?php } ?>
                </div>

                <?php if(!empty(AuthenticationService::$singleton->user->id)) { ?>
                <div id="current_user_header">
                    <?= htmlspecialchars(AuthenticationService::$singleton->user->getDisplayName()) ?>
                    &nbsp;
                    <a href="/logout"><?= htmlspecialchars(lang_get('logout')) ?></a>
                </div>
                <?php } ?>
            </div>
        </div>
        <div id="mainLayout" class="layout">
            <?= $content_for_layout ?>
        </div>
        <div id="footer">
            <?= sprintf(lang_get('copyright'), date_localized('Y')) ?>
        </div>
    </body>
</html>