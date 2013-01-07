<?php $default = isset($default) ? $default : ''; ?>
<textarea
    class="textarea <?= isset($class) ? $class : '' ?>"
    name="<?= isset($name) ? $name : '' ?>"
    default_text="<?= $default ?>"><?= isset($value) && $value !== null && !empty($value) ? $value : $default ?></textarea>