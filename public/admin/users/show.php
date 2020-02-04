<?php require_once '../../../private/initialize.php'; ?>

<?php

$page_title = 'Show User';

// Get id from the URL
$id = $_GET['id'] ?? '';

// If no id in URL go to index
if (!$id) {
  redirect_to(url_for('/admin/users/index.php'));
}

// If id get the user
$user = User::find_by_id(h($id));

// If nothing found in the database, redirect to index
if (!$user) {
  redirect_to(url_for('/admin/users/index.php'));
}

//var_dump($user);

?>

<?php include_once SHARED_PATH . '/admin_header.php'; ?>

<a href="<?php echo url_for('/admin/users/index.php'); ?>">
  <button class="btn-link" role="link">&larr;Back To List</button>
</a>

<section class="show-single">
  <div class="show-single-text">
    <h3>Email: <?php echo h($user->email); ?></h3>
    <h3>Username: <?php echo h($user->username); ?></h3>
    <h3><?php echo $user->is_admin == '1' ? 'Administrator' : 'User'; ?></h3>
    <h3>Created: <?php echo date('d/m Y', h($user->created)); ?></h3>
    <h3>Last Login: <?php echo $user->last_logged_in != '0' ? date('d/m Y', h($user->last_logged_in)) : 'Never'; ?></h3>
  </div>

  <div class="button-bar">
    <a href="<?php echo url_for('/admin/users/edit.php?id=' . h(u($id))) ?>">
      <button class="btn-link" role="link">Edit</button>
    </a>
    <a href="<?php echo url_for('/admin/users/delete.php?id=' . h(u($id))) ?>">
      <button class="btn-danger" role="link">Delete</button>
    </a>

  </div>
</section>



<?php include_once SHARED_PATH . '/admin_footer.php'; ?>