<?php require_once '../../../private/initialize.php'; ?>

<?php

$page_title = 'Admin Area - Show Format';

$id = $_GET['id'] ?? '';

if (!$id) {
  redirect_to(url_for('/admin/formats/index.php'));
}

$format = Format::find_by_id(h($id));

if (empty($format)) {
  redirect_to(url_for('/admin/formats/index.php'));
}

?>

<?php include_once SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/formats/index.php'); ?>">
  <button class="btn-link" role="link">&larr; Back To List</button>
</a>

<section class="display-box">

  <div class="display-header">
    <h2>Show Format</h2>
  </div>

  <div class="display-content">
    <p>ID: <?php echo h($format->id); ?> Name: <?php echo h($format->name); ?></p>
  </div>

  <div class="button-bar-more">

    <a href="<?php echo url_for('/admin/formats/index.php'); ?>">
      <button class="btn-success" role="link">Ok</button>
    </a>

    <a href="<?php echo url_for('admin/formats/edit.php?id=' . h(u($id))) ?>">
      <button class="btn-link" role="link">Edit</button>
    </a>

    <a href="<?php echo url_for('/admin/formats/delete.php?id=' . h(u($id))); ?>">
      <button class="btn-danger" role="link">Delete</button>
    </a>

  </div>


</section>

<?php include_once SHARED_PATH . '/footer.php'; ?>