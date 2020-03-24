<?php

// Prevents this code to be loaded in a broser
// without first setting the nessasary object
if (!isset($wishlist)) {
  redirect_to(url_for('/admin/records/show.php?id=' . h(u($record->id))));
}

?>

<input type="hidden" name="wishlist[user_id]" value="<?php echo h($session->user_id); ?>" />

<input type="hidden" name="wishlist[record_id]" value="<?php echo h($record->id); ?>" />

<div class="select-box">
  <label for="wishlist[format_id]">Format: </label>
  <select name="wishlist[format_id]">
    <?php $formats = Format::find_all();
    foreach ($formats as $format) { ?>
      <option value="<?php echo h($format->id) ?>">
        <?php echo h($format->name); ?>
      </option>
    <?php } ?>
  </select>
</div>