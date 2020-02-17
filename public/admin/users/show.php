<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* "Normal" user can only see their own account.
* Administrator can see all accounts. 
*/

require_login();

if ($session->is_admin()) {
  $page_title = 'Admin Area - Show User';
} else {
  $page_title = 'Your Account';
}

// Get id from the URL
$id = $_GET['id'] ?? '';

// If no id in URL go to index
if (!$id) {
  if ($session->is_admin()) {
    redirect_to(url_for('/admin/users/index.php'));
  } else {
    redirect_to(url_for('/index.php'));
  }
}

// Users can only see their own account, else return them to front page
if (!$session->is_admin() && $_SESSION['user_id'] != $id) {
  redirect_to(url_for('/index.php'));
}

// If id get the user
$user = User::find_by_id(h($id));

// If nothing found in the database, redirect to index
if (!$user) {
  if ($session->is_admin()) {
    redirect_to(url_for('/admin/users/index.php'));
  } else {
    redirect_to(url_for('/index.php'));
  }
}

//var_dump($user);

?>

<?php include SHARED_PATH . '/header.php'; ?>

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
    <h2>Show Account</h2>
  </div>

  <div class="display-content">
    <h3>Email: <?php echo h($user->email); ?></h3>
    <h3>Username: <?php echo h($user->username); ?></h3>
    <h3><?php echo $user->is_admin == '1' ? 'Administrator' : 'User'; ?></h3>
    <h3>Created: <?php echo date('d/m Y', h($user->created)); ?></h3>
    <h3>Last Login: <?php echo $user->last_logged_in != '0' ? date('d/m Y', h($user->last_logged_in)) : 'Never'; ?></h3>


    <div class="button-bar">
      <a href="<?php echo $session->is_admin() ? url_for('/admin/users/index.php') : url_for('/index.php'); ?>">
        <button class="btn-success" role="link">Ok</button>
      </a>
      <a href="<?php echo url_for('/admin/users/edit.php?id=' . h(u($id))) ?>">
        <button class="btn-link" role="link">Edit</button>
      </a>
      <a href="<?php echo url_for('/admin/users/delete.php?id=' . h(u($id))) ?>">
        <button class="btn-danger" role="link">Delete</button>
      </a>
    </div>
  </div>
</section>



<?php include SHARED_PATH . '/footer.php'; ?>