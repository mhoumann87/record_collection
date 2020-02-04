<?php require_once '../../../private/initialize.php'; ?>

<?php

// Get id from URL
$id = $_GET['id'] ?? '';

// If no is with URL return to index.php
if (!$id) {
  redirect_to(url_for('/admin/users/index.php'));
}

$user = User::find_by_id($id);

// If no user found return to index.php
if ($user == false) {
  redirect_to(url_for('/admin/users/index.php'));
}

// Set page title with username
// TODO set $page_title based on administrator
//if (is admin) {
// $page_title = 'Delete user'.$user->username;
//} else {
$page_title = 'Delete Account: ' . $user->username;
// }

if (is_post_request()) {

  // Delete the user
  $user->delete();

  //$session->message("The user account {$user->username} was deleted successfully)
  // TODO different redicect for admin and user
  //if (admin) {
  redirect_to(url_for('/admin/users/index.php'));
  //} else {
  //redirect_to(url_for('index.php'));
  //}
} else {
  // Display the user
}

?>

<?php include_once SHARED_PATH . '/admin_header.php'; ?>

<a href="<?php echo url_for('/admin/users/index.php'); ?>">
  <button class="btn-link" role="link">&larr;Back To List</button>
</a>

<section class="show-single">
  <div class="show-single-text">
    <h3>Do you really want to delete this account?</h3>
    <p>Email: <?php echo h($user->email); ?></p>
    <p>Username: <?php echo h($user->username); ?></p>

    <form action="<?php echo url_for('/admin/users/delete.php?id=' . h(u($id))); ?>" method="post">
      <div class="button-bar">
        <input class="button btn-danger" type="submit" value="Yes, delete account">
        <a href="<?php echo url_for('/admin/users/index.php') ?>">
          <button class="btn-success">No, back to list</button>
        </a>
      </div>
    </form>
  </div>
</section>

<?php include_once SHARED_PATH . '/admin_footer.php'; ?>