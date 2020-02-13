<?php require_once '../../../private/initialize.php'; ?>

<?php require_admin_role(); ?>

<?php

$page_title = 'Admin Area - Create New Format';

if (is_post_request()) {
  // If it is a post request, instanziate a new format

  $args = $_POST['format'];
  $format = new Format($args);
  $result = $format->save();
  $set_id = $format->id;

  if ($result === true) {
    $session->message("Format was created successfuly");
    redirect_to(url_for('admin/formats/show.php?id=' . h(u($set_id))));
  } else {
    // Show errors, happends automatically, this is just to keem me sane
  }
} else {
  // This is a GET request, so we just show the form with an empty format
  $format = new Format;
}
?>

<?php include_once SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/formats/index.php'); ?>">
  <button class="btn-link" role="link">&larr; Back To List</button>
</a>

<section class="display-box">

  <div class="display-header">
    <h2>Create Format</h2>
  </div>

  <div class="display-content">

    <?php echo display_errors($format->errors); ?>

    <form action="<?php echo url_for('/admin/formats/new.php'); ?>" method="post">

      <?php include_once './form_fields.php'; ?>

      <div class="button-box">
        <input type="submit" class="button btn-success" value="Create" />
      </div>

    </form>

  </div>

</section>


<?php include_once SHARED_PATH . '/footer.php'; ?>