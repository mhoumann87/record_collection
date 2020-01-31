<?php require_once '../../../private/initialize.php'; ?>

<?php

$page_title = 'Edit Grade';

$id = $_GET['id'] ?? '';

// If no id is send with the request, just return to the list
if ($id === '') {
  redirect_to(url_for('/admin/grades/index.php'));
}

// If you get an id try to get that post from the database
$grade = Grade::find_by_id(h($id));

// If the grade isn't in the database, return to th list
if ($grade === false) {
  redirect_to(url_for('/admin/grades/index.php'));
}

// Check to see if it is a post request
if (is_post_request() && isset($_POST['submit'])) {
  // POST request

  // Get what is in the input fields
  $args = $_POST['grade'];

  // Merge attributes and save the grade
  $grade->merge_attributes($args);
  $grade->prepare_upload();
  $result = $grade->save();

  if ($result === true) {
    //$session->message('The grading were edited succesfully');
    redirect_to(url_for('/admin/grades/show.php?id=' . h(u($id))));
  }
} else {
  // GET request
  // Show the form, no need to have this else, it is just to keep my brain straight
} // is_post_request()

?>

<?php include_once SHARED_PATH . '/admin_header.php'; ?>

<a href="<?php echo url_for('/admin/grades/index.php'); ?>">
  <button class="btn-link">&larr;Back To List</button>
</a>

<section="input-page">

  <?php echo display_errors($grade->errors) ?>

  <form action="<?php echo url_for('/admin/grades/edit.php?id=' . h(u($id))); ?>" method="post">

    <?php
    if ($grade->image != '') {
      echo '<div class="image">';
      echo '<img src="' . url_for("/assets/images/") . h($grade->image) . '" alt="">';
      echo '</div>';
    } else {
      echo '';
    }
    ?>

    <?php include_once 'form_fields.php'; ?>

    <div class="input-bax">
      <input type="submit" name="submit" class="button btn-success" value="Edit Grade">

    </div>

  </form>

  </section>

  <?php include_once SHARED_PATH . '/admin_footer.php'; ?>