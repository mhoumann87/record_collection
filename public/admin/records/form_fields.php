<?php

// Prevents this code from being loaded in the browser
// without first setting the nessasary object
if (!isset($record)) {
  redirect_to(url_for('/index.php'));
}

?>

<div class="input-box">
  <label for="redord[title]">Title: </label>
  <input type="text" name="redord[title]" value="<?php echo h($redord->title); ?>" />
</div>

<div class="input-box">
  <label for="redord[year]">Year Released: </label>
  <input type="text" name="redord[year]" value="<?php echo h($redord->year); ?>" />
</div>

<div class="input-box">
  <label for="redord[information]">redord Information: </label>
  <textarea name="redord[information]"><?php echo $redord->information; ?></textarea>
</div>

<p class="dark">Enter Image Link</p>

<div class="input-box">
  <label for="redord[image-link]">Link to Image: </label>
  <input type="text" name="redord[image_link]">
</div>

<p class="dark">Or Upload an Image</p>

<div class="input-box">
  <label for="redord[image]">Upload Image (max <?php echo $redord->max_megabytes; ?>MB)</label>
  <input type="file" name="redord[image]">
</div>