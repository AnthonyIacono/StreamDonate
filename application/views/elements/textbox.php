<?php $default = isset($default) ? $default : ''; ?>
<input type="text"
    class="textbox <?= htmlspecialchars(isset($class) ? $class : '') ?>"
    name="<?= htmlspecialchars(isset($name) ? $name : '') ?>"
    default_text="<?= htmlspecialchars($default) ?>"
    value="<?= htmlspecialchars(isset($value) && $value !== null && !empty($value) ? $value : $default) ?>" />