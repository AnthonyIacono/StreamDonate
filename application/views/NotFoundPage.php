<style type="text/css">
    #notFoundContentBox {
        width: 480px;
        margin: 0 auto;
        text-align: center;
    }
</style>
<div id="notFoundPage" data-href="<?= $this->resource->request->uri ?>">
    <div id="notFoundContentBox">
        <div class="contentBoxHeader">
            <?= htmlspecialchars(lang_get('resource_not_found_title')) ?>
        </div>
        <div class="contentBoxBody">
            <p class="red"><?= htmlspecialchars(lang_get('resource_not_found_subtitle')) ?></p>
            <div class="contentBoxDivider">&nbsp;</div>
            <p><?= htmlspecialchars(lang_get('resource_not_found_paragraph')) ?></p>
        </div>
    </div>
</div>