<?php
ob_start();
?>
<p style="text-align: center"><?= $message ?></p>
<div class="buttons" style="text-align: center">
<?php
foreach($buttons as $class => $button) {
    $buttons[$class]['id'] = uniqid();
    $color = isset($button['color']) ? $button['color'] : 'GreenRect';
    $color[0] = strtoupper($color[0]);
    ?>
<input type="button" id="<?= $buttons[$class]['id'] ?>" class="btn<?= $color ?>" value="<?= htmlspecialchars($button['text']) ?>" />
<?php
}
?>
</div>
<?php
$body = ob_get_contents();
ob_end_clean();

ob_start();
?>
<?php foreach($buttons as $button) { ?>
$('#<?= $button['id'] ?>').click(function() {

    <?= isset($button['click']) ? $button['click'] : '' ?>

$(overlay).gOverlayRemove();

    <?= isset($after) && null !== $after ? $after : '' ?>

});
<?php } ?>
<?php
$js = ob_get_contents();
ob_end_clean();
?>
<?= $this->element('overlay', array(
    'title' => $title,
    'body' => $body,
    'js' => $js,
    'click_mask_to_exit' => false,
    'class' => 'messagebox'
)) ?>