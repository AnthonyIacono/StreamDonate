<?php $default = isset($default) ? $default : ''; ?>
<div class="passwordbox">
    <input type="text"
           class="passwordbox <?= isset($class) ? $class : '' ?>"
           value="<?= $default ?>" />
    <input type="password"
           class="realpasswordbox <?= isset($class) ? $class : '' ?>"
           value=""
           name="<?= isset($name) ? $name : '' ?>"
           style="display: none" />
</div>