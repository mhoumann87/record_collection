<?php

// Prevents this code from being loaded in the browser
// without first setting the nessasary object
if (!isset($artist)) {
  redirect_to(url_for('admin/artists/index.php'));
}

?>


<div class="input-box">
  <label for="artist[firstname]">First Name (Band Name):</label>
  <input type="text" name="artist[firstname]" value="<?php echo h($artist->firstname); ?>" />
</div>

<div class="input-box">
  <label for="artist[lastname]">Last Name:</label>
  <input type="text" name="artist[lastname]" value="<?php echo h($artist->lastname); ?>" />
</div>

<p class="dark">Enter an image link</p>

<div class="input-box">
  <label for="artist[image_link]">Image Link:</label>
  <input type="text" name="artist[image_link]" value="" />
</div>

<p class="dark">Or upload an image</p>

<div class="input-box">
  <label for="artist[image]">Upload Image:</label>
  <input type="file" name="artist[image]" />
</div>

<div class="input-box">
  <label for="artist[profile]">Artist Profile:</label>
  <textarea name="artist[profile]"><?php echo $artist->profile; ?></textarea>
</div>

<div class="input-box">
  <label for="artist[website]">Official Website</label>
  <input type="text" name="artist[website]" value="<?php echo h($artist->website); ?>" />
</div>

<?php if ($session->is_admin() && isset($artist->id)) { ?>
  <div class="radio-box">
    <label for="artist[show_artist]">Show this artist: </label>
    <input type="radio" name="artist[show_artist]" value="0" <?php echo ($artist->show_artist == 0) ? 'checked="checked"' : ''; ?>>No&nbsp;
    <input type="radio" name="artist[show_artist]" value="1" <?php echo ($artist->show_artist > 0) ? 'checked="checked"' : ''; ?>>Yes
  </div>
<?php } ?>