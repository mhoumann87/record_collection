<?php

// Prevents this code from being loaded in the browser
// without first setting the nessasary object
if (!isset($record)) {
  redirect_to(url_for('/index.php'));
}

?>

<div class="input-box">
  <label for="record[title]">Title: </label>
  <input type="text" name="record[title]" value="<?php echo h($record->title); ?>" />
</div>

<div class="input-box">
  <label for="record[year]">Year Released: </label>
  <input type="text" name="record[year]" value="<?php echo h($record->year); ?>" />
</div>

<div class="input-box">
  <label for="record[information]">record Information: </label>
  <textarea name="record[information]"><?php echo $record->information; ?></textarea>
</div>

<p class="dark">Enter Image Link</p>

<div class="input-box">
  <label for="record[image-link]">Link to Image: </label>
  <input type="text" name="record[image_link]">
</div>

<p class="dark">Or Upload an Image</p>

<div class="input-box">
  <label for="record[image]">Upload Image (max <?php echo $record->max_megabytes; ?>MB)</label>
  <input type="file" name="record[image]">
</div>

<?php

/*
* Only admins should see this radio input, and only if it is an edit to the page
  TODO It should only be an admin not made this post (in development we skip this)
*/
if ($session->is_admin() && isset($record->id)) { ?>

  <div class="radio-box">
    <label for="record[show_record]">Show this album: </label>
    <input type="radio" name="record[show_record]" value="0" <?php echo ($record->show_record == 0) ? 'checked="checked"' : ''; ?>>No&nbsp;
    <input type="radio" name="record[show_record]" value="1" <?php echo ($record->show_record > 0) ? 'checked="checked"' : ''; ?>>Yes
  </div>

<?php } ?>