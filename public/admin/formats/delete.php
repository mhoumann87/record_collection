<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* This area is for administrators only.
* The content is just user ad "service"
* the main pages 
*/

$page_title = 'Admin Area - Delete Format';

require_admin_role();

$id = $_GET['id'] ?? '';

if (empty($id)) {
  redirect_to(url_for('/admin/formats/index.php'));
}

$format = Format::find_by_id(h($id));

if ($format == false) {
  redirect_to(url_for('/admin/formats/index.php'));
}

if (is_post_request()) {
  // The user confirmed the deletion
  $format->delete();
  $session->message("The format {$format->name} was deleted sucessfully");
  redirect_to(url_for('/admin/formats/index.php'));
} else {
  // Just show the info
}
?>

<?php include_once SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/formats/index.php'); ?>">
  <button class="btn-link" role="link">&larr; Back To List</button>
</a>

<section class="display-box">

  <div class="display-header">
    <h2>Delete <?php echo h($format->name); ?></h2>
  </div>

  <div class="display-content">
    <h3>ID: <?php echo h($format->id); ?></h3>
    <h3>Name: <?php echo h($format->name); ?></h3>

    <div class="delete-post">
      <h3>Do you really want to delete this format?</h3>
    </div>

    <div class="button-bar">

      <form action="<?php echo url_for('/admin/formats/delete.php?id=' . h(u($id))); ?>" method="post">
        <input type="submit" name="submit" class="button btn-danger" value="Yes, delete format">
      </form>

      <a href="<?php echo url_for('/admin/formats/index.php'); ?>">
        <button class="btn-success" role="link">No, back to list</button>
      </a>

    </div>

  </div>

</section>