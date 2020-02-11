<?php require_once '../../../private/initialize.php'; ?>

<?php
require_login();

// Get id from URL
$id = $_GET['id'] ?? '';

// If no id with URL return to index.php
if (!$id) {
  if ($session->is_admin()) {
    redirect_to(url_for('/admin/users/index.php'));
  } else {
    redirect_to((url_for('/index.php')));
  }
}

// Users can only access their own account, else send to front page
if (!$session->is_admin() && $_SESSION['user_id'] != $id) {
  redirect_to(url_for('/index.php'));
}

$user = User::find_by_id($id);

// If no user found return to index.php
if ($user == false) {
  if ($session->is_admin()) {
    redirect_to(url_for('/admin/users/index.php'));
  } else {
    redirect_to((url_for('/index.php')));
  }
}

// Set page title with username
if ($session->is_admin()) {
  $page_title = 'Admin Area - Delete user: ' . $user->username;
} else {
  $page_title = 'Delete Account: ' . $user->username;
}

if (is_post_request()) {

  // Delete the user
  $user->delete();

  $session->message("The user account {$user->username} was deleted successfully");

  if ($session->is_admin()) {
    redirect_to(url_for('/admin/users/index.php'));
  } else {
    redirect_to(url_for('/index.php'));
  }
} else {
  // Display the user
}

?>

<?php include_once SHARED_PATH . '/header.php'; ?>

<?php if ($session->is_admin()) { ?>
  <a href="<?php echo url_for('/admin/users/index.php'); ?>">
    <button class="btn-link" role="link">&larr;Back To List</button>
  </a>
<?php } else { ?>
  <a href="<?php echo url_for('/index.php'); ?>">
    <button class="btn-link" role="link">&larr; Back To Front Page</button>
  </a>
<?php } ?>

<section class="display-box">

  <div class="display-header">
    <h2>Delete Account</h2>
  </div>

  <div class="display-content">
    <h3>Do you really want to delete this account?</h3>
    <p>Email: <?php echo h($user->email); ?></p>
    <p>Username: <?php echo h($user->username); ?></p>

    <form action="<?php echo url_for('/admin/users/delete.php?id=' . h(u($id))); ?>" method="post">
      <div class="button-bar">
        <input class="button btn-danger" type="submit" value="Yes, delete account">

        <?php if ($session->is_admin()) { ?>
          <a href="<?php echo url_for('/admin/users/index.php') ?>">
            <button class="btn-success">No, back to list</button>
          </a>
        <?php } else { ?>
          <a href="<?php echo url_for('/index.php') ?>">
            <button class="btn-success">No, back to front page</button>
          </a>
        <?php } ?>
      </div>
    </form>
  </div>
</section>

<?php include_once SHARED_PATH . '/footer.php'; ?>