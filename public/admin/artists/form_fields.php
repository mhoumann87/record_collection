<?php

// Prevents this code from being loaded in the browser
// without first setting the nessasary object
if (!isset($artist)) {
  redirect_to(url_for('admin/artists/index.php'));
}

?>

<h2>Band Name</h2>

<div class="input-box">
  <label for="artist[bandname]">Band Name (- 'The'):</label>
  <input type="text" name="artist[bandname]" value="<?php echo h($artist->bandname); ?>" />
</div>

<div class="checkbox">
  <label for="artist[the_first]">Start with 'The':</label>
  <input type="checkbox" name="artist[the_first]" value="1" />
</div>

<h2>Or Artist Name</h2>