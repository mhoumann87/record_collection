<?php require_once "../../../private/initialize.php"; ?>

<?php

require_admin_role();

$page_title = 'Admin Area - Formats Home';

include SHARED_PATH . '/header.php';
?>

<a href="<?php echo url_for('/admin/formats/new.php'); ?>">
  <button class="btn-link">Create New Format</button>
</a>

<h1>Formats Home</h1>

<?php include_once SHARED_PATH . '/footer.php'; ?>