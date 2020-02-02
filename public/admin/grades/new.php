<?php require_once '../../../private/initialize.php'; ?>

<?php $page_title = 'Add Grade'; ?>

<?php

if (is_post_request()) {
  // If it is a post request instianziate a new grade

  // "Collent" all the input from user in an array
  $args = $_POST['grade'];

  // Create a new instance with with info from $args
  $grade = new Grade($args);

  // Prepare the instance to upload
  $grade->prepare_upload();

  // Validate input
  $valid = $grade->check_validation();

  //var_dump($valid);

  if (empty($valid)) {
    // The input was validated and we upload the grade to the database
    $result = $grade->save();
    $set_id = $grade->id;

    // If the upload succeded redirect to show.php
    if ($result === true) {
      // $session->message('Grade saved successfully');
      redirect_to(url_for('/admin/grades/show.php?id=' . h(u($set_id))));
    }
  }
} else {

  // If it is a get request, just show the form with an empty post

  $grade = new Grade;
}
?>

<?php include SHARED_PATH . '/admin_header.php'; ?>

<a href="<?php echo url_for('/admin/grades/index.php'); ?>">
  <button class="btn-link" role="link">&larr;Back To List</button>
</a>

<section class="input-page">

  <?php echo display_errors($grade->errors); ?>

  <form action="<?php echo url_for('/admin/grades/new.php'); ?>" method="post">

    <div class="form-box">
      <?php include 'form_fields.php' ?>

      <div class="button-box">
        <input type="submit" class="button btn-success" value="Create Grade">
      </div>
    </div>
  </form>

</section>

<?php include SHARED_PATH . '/admin_footer.php'; ?>