<?php require_once '../../../private/initialize.php'; ?>

<?php $page_title = 'Add Grade'; ?>

<?php

if (is_post_request()) {
  // If it is a post request instianziate a new grade
  $args = $_POST['grade'];

  //var_dump($args);
  // "Clean" html for allowed tags
  $grade->definition = $grade->clear_html_input($grade->definition);
  echo $grade->definition;
} else {

  // If it is a get request, just show the form with an empty post

  $grade = new Grade;
}
?>

<?php include SHARED_PATH . '/admin_header.php'; ?>

<a href="<?php echo url_for('/admin/grades/index.php'); ?>">
  <button class="btn-link">&larr;Back To List</button>
</a>
<section class="input-page">

  <?php echo display_errors($grade->errors); ?>

  <form action="<?php echo url_for('/admin/grades/new.php'); ?>" method="post">

    <?php include 'form_fields.php' ?>

    <div class="input-box">
      <input type="submit" class="button btn-success" value="Create Grade">
    </div>
  </form>

</section>

<?php include SHARED_PATH . '/admin_footer.php'; ?>