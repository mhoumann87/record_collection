<?php

// Prevents this code from being loaded in the browser
// withput first setting the nessary object

/* if (!isset($grade)) {
  redirect_to(url_for('/admin/grades/index.php'));
} */
?>

<div class="input-box">

  <label for="value">Value of the grading: </label>
  <input type="text" name="grade[value]" value="<?php echo h($grade->value); ?>" autofocus>

</div>

<div class="input-box">

  <label for="short">Short name: </label>
  <input type="text" name="grade[short]" value="<?php echo h($grade->value); ?>">

</div>

<div class="input-box">

  <label for="description">Definition: </label>
  <textarea name="grade[definition]">
    <?php echo h($grade->definition); ?>
  </textarea>

</div>

<div class="input-box">

  <label for="image">Link to image:</label>
  <input type="text" name="grade[image]" value="<?php echo h($grade->image); ?>">

</div>