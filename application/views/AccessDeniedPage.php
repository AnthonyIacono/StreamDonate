<style type="text/css">
    #accessDeniedContentBox {
        width: 480px;
        margin: 0 auto;
        text-align: center;
    }
</style>
<div id="accessDeniedPage" data-href="<?= $this->resource->request->uri ?>">
    <div id="accessDeniedContentBox">
        <div class="contentBoxHeader">
            <?= htmlspecialchars(lang_get('resource_access_denied_title')) ?>
        </div>
        <div class="contentBoxBody">
            <p class="red"><?= htmlspecialchars(lang_get('resource_access_denied_subtitle')) ?></p>
            <div class="contentBoxDivider">&nbsp;</div>
            <p><?= htmlspecialchars(lang_get('resource_access_denied_paragraph')) ?></p>
        </div>
    </div>
</div>