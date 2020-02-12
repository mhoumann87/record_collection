<?php require_once '../../../private/initialize.php'; ?>

<?php

require_login();

if ($session->is_admin()) {
  $page_title = 'Admin Area - Edit User';
} else {
  $page_title = 'Edit account';
}

// Check to see an id is included in URL, else go back
if (!isset($_GET['id'])) {
  if ($session->is_admin()) {
    redirect_to(url_for('/admin/users/index.php'));
  } else {
    redirect_to(url_for('/index.php'));
  }
} else {
  $id = $_GET['id'];
}

// Users can only see their account, else send to front page
if (!$session->is_admin() && $_SESSION['user_id'] != $id) {
  redirect_to(url_for('/index.php'));
}
// Find user in database, else go back

$user = User::find_by_id(h($id));

if ($user === false) {
  if ($session->is_admin()) {
    redirect_to(url_for('/admin/users/index.php'));
  } else {
    redirect_to(url_for('/index.php'));
  }
}

if (is_post_request()) {
  // POST request, "collect" info from user input
  $args = $_POST['user'];
  $user->merge_attributes($args);
  $result = $user->save();

  if ($result === true) {
    $session->message("User {$user->username} was updated successfully");
    redirect_to(url_for('/admin/users/show.php?id=' . h(u($id))));
  } else {
    // Show errors
  }
} else {
  // GET request, show the form
}
?>

<?php include_once SHARED_PATH . '/header.php'; ?>

<?php if ($session->is_admin()) { ?>
  <a href="<?php echo url_for('/admin/users/index.php'); ?>">
    <button class="btn-link">&larr;Back To List</button>
  </a>
<?php } else { ?>

  <a href="<?php echo url_for('/index.php'); ?>">
    <button class="btn-link">&larr;Back To Front Page</button>
  </a>
<?php } ?>

<div class="display-box">

  <div class="display-header">
    <h2>Edit Account - <?php echo $user->username; ?></h2>
  </div>

  <?php echo display_errors($user->errors); ?>

  <form action="<?php echo url_for('admin/users/edit.php?id=' . h(u($id))); ?>" method="post">

    <div class="display-content">

      <?php include_once 'form_fields.php'; ?>

      <div class="button-bar-single">
        <input type="submit" class="button btn-success" value="Edit User">
      </div>

    </div>

  </form>

</div>

<?php include_once SHARED_PATH . '/footer.php'; ?>