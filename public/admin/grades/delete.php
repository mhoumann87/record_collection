<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* This area is for administrators only.
* The content is just user ad "service"
* the main pages 
*/

require_admin_role();

// Get the id from the URL, in there isn't any go back to list
$id = $_GET['id'] ?? '';

if (!$id) {
  redirect_to(url_for('/admin/grades/index.php'));
}

// Get the grade with the id, if there isn't any, return to the list
$grade = Grade::find_by_id($id);

if ($grade == false) {
  redirect_to(url_for('/admin/grades/index.php'));
}

$page_title = 'Admin Area - Delete Grade: ' . ucfirst(h($grade->value));

if (is_post_request()) {
  // User wants to delete the grade
  $grade->delete();
  $session->message("The Grade {$grade->value} was deleted successfully");
  redirect_to(url_for('/admin/grades/index.php'));
}

?>

<?php include SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/grades/index.php'); ?>">
  <button class="btn-link" role="link">&larr; Back to list</button>
</a>

<section class="display-box">

  <?php if (isset($grade->image)) { ?>
    <div class="display-header-image">
      <h2>Delete Grade</h2>
    </div>

    <img src="<?php echo url_for('/assets/images/') . $grade->image; ?>" alt="">
  <?php } else { ?>
    <div class="display-header">
      <h2>Delete Grade</h2>
    </div>
  <?php } ?>

  <?php echo display_errors($grade->errors); ?>

  <div class="display-content">
    <h3>Name: <?php echo h(ucfirst($grade->value)); ?></h3>
    <h3>Short: <?php echo h($grade->short); ?></h3>
    <h3>Description:</h3>
    <div class="description">
      <?php echo $grade->definition; ?>
    </div>

    <div class="delete-post">
      <h3>Do you really want to delete this post?</h3>

      <div class="button-bar">
        <form method="post" action="<?php echo url_for('/admin/grades/delete.php?id=' . h(u($id))); ?>">
          <input class="button btn-danger" type="submit" value="Yes, delete grade">
        </form>

        <a href="<?php echo url_for('/admin/grades/index.php'); ?>">
          <button class="btn-success" role="link">No, back to list</button>
        </a>
      </div>

    </div>

  </div>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>