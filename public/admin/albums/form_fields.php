<?php

// Prevents this code from being loaded in the browser
// without first setting the nessasary object
if (!isset($album)) {
  redirect_to(url_for('/index.php'));
}

?>

<div class="input-box">
  <label for="album[title]">Title: </label>
  <input type="text" name="album[title]" value="<?php echo h($album->title); ?>" />
</div>

<div class="input-box">
  <label for="album[year]">Year Released: </label>
  <input type="text" name="album[year]" value="<?php echo h($album->year); ?>" />
</div>

<div class="input-box">
  <label for="album[information]">Album Information: </label>
  <textarea name="album[information]"><?php echo $album->information; ?></textarea>
</div>

<p class="dark">Enter Image Link</p>

<div class="input-box">
  <label for="album[image-link]">Link to Image: </label>
  <input type="text" name="album[image_link]">
</div>

<p class="dark">Or Upload an Image</p>

<div class="input-box">
  <label for="album[image]">Upload Image (max <?php echo $album->max_megabytes; ?>MB)</label>
  <input type="file" name="album[image]">
</div>