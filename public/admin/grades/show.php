<?php require_once '../../../private/initialize.php'; ?>

<?php

// Get the id from the URL if it is not there set id to empty
$id = $_GET['id'] ?? '';

if (!$id) {
  redirect_to(url_for('/admin/grades/index.php'));
}

$grade = Grade::find_by_id($id);

if (empty($grade)) {
  redirect_to(url_for('/admin/grades/index.php'));
}

$page_title = 'View Grade ' . h($grade->short);
?>

<?php include_once SHARED_PATH . '/admin_header.php'; ?>

<a href="<?php echo url_for('/admin/grades/index.php'); ?>">
  <button class="btn-link" role="link">&larr; Back to list</button>
</a>

<section class="show-single">
  <img src="<?php echo url_for('/assets/images/') . $grade->image; ?>" alt="">
  <div class="show-single-text">
    <h3>Name: <?php echo h(ucfirst($grade->value)); ?></h3>
    <h3>Short: <?php echo h($grade->short); ?></h3>
    <h3>Description:</h3>
    <div class="description">
      <?php echo $grade->definition; ?>
    </div>
    <div class="button-bar">
      <a href="<?php echo url_for('/admin/grades/edit.php?id=' . $grade->id); ?>">
        <button class="btn-link" role="link">Edit</button></a></a>
      <a href="<?php echo url_for('/admin/grades/delete.php?id=' . $grade->id); ?>"> <button class="btn-danger" role="link">Delete</button></a></a>
    </div>
  </div>
</section>

<?php include_once SHARED_PATH . '/admin_footer.php'; ?>