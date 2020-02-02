<?php require_once '../../../private/initialize.php'; ?>

<?php

$page_title = 'Users Front Page';
?>


<?php include_once SHARED_PATH . '/admin_header.php'; ?>

<a href="<?php echo url_for('/admin/users/new.php'); ?>">
  <button class="btn-link" role="link">Create New</button>
</a>

<?php include_once SHARED_PATH . '/admin_footer.php'; ?>