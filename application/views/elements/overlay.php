<?php
$id = uniqid();
?>
<div class="<?= $class ?> overlay" style="display: none" id="<?= $id ?>">
<?php
if(isset($title)) {
?>
    <h2><?= $title ?></h2>
<?php } ?>
    <?= $body ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var overlay = $('#<?= $id ?>').gOverlay({
            load: false,
            mask: '#252525'
        });

        $(overlay).gOverlayLoad();

        $('#<?= $id ?> .close').click(function() {
            $(overlay).gOverlayRemove();
            return false;
        });

        var repositionInterval = setInterval(function() {
            if($('#<?= $id ?>').length == 0) {
                clearInterval(repositionInterval);
                return;
            }

            var topPos = parseInt(($(window).height() / 2) - ($('#<?= $id ?>').outerHeight() / 2), 10);
            var leftPos = parseInt(($(window).width() / 2) - ($('#<?= $id ?>').outerWidth() / 2), 10);

            $('#<?= $id ?>').css('left', leftPos + 'px').css('top', topPos + 'px');
        }, 50);

    <?= isset($js) ? $js : '' ?>

    });
</script>
