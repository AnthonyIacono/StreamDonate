<style type="text/css">
    #brokenLinkContentBox {
        width: 480px;
        margin: 0 auto;
        text-align: center;
    }
</style>
<div id="brokenLinkPage" data-href="<?= $this->resource->request->uri ?>">
    <div id="brokenLinkContentBox">
        <div class="contentBoxHeader">
            <?= htmlspecialchars(lang_get('resource_broken_link_title')) ?>
        </div>
        <div class="contentBoxBody">
            <p class="red"><?= htmlspecialchars(lang_get('resource_broken_link_subtitle')) ?></p>
            <div class="contentBoxDivider">&nbsp;</div>
            <p><?= htmlspecialchars(lang_get('resource_broken_link_paragraph')) ?></p>
        </div>
    </div>
</div>