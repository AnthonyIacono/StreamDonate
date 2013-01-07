<div class="selectbox-simple">
    <select name="<?= $name ?>">
        <?php foreach($items as $v => $text) { ?>
        <option <?= isset($value) && $value == $v ? 'selected="selected"': '' ?> value="<?= htmlspecialchars($v) ?>"><?= htmlspecialchars($text) ?></option>
        <?php } ?>
    </select>
</div>