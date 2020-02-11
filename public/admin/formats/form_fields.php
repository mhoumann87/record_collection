<?php

// Prevents this code from being loaded in the browser
// without first setting the nessary pbject
if (!isset($format)) {
  redirect_to(url_for('/admin/formats/index.php'));
}

?>

<div class="input-box">
  <label for="format[name]">Name:</label>
  <input type="text" name="format[name]" value="<?php echo h($format->name); ?>" autofocus />
</div>