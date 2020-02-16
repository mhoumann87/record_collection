<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
 * Everybody can create a new account.
 */

if ($session->is_admin()) {
  $page_title = 'Create New User';
} else {
  $page_title = 'Sign Up';
}
?>

<?php

if (is_post_request()) {
  // POST request
  // If the form data is submitted, create record based on these parameters
  // "Collect" all the parameters in an array
  $args = $_POST['user'];
  $user = new User($args);
  $user->set_created_at();
  $result = $user->save();

  if ($result === true) {
    $new_id = $user->id;
    $session->message("User was created successfully");
    redirect_to(url_for('/admin/users/show.php?id=' . $new_id));
  } else {
    // Show errors
  }
} else {
  // GET request
  // Show the form with an "empty" user
  $user = new User;
} // if

?>

<?php include_once SHARED_PATH . '/header.php'; ?>

<?php if ($session->is_admin()) { ?>
  <a href="<?php echo url_for('/admin/users/index.php'); ?>">
    <button class="btn-link" role="link">&larr;Back to List</button>
  </a>
<?php } else { ?>
  <a href="<?php echo url_for('/index.php'); ?>">
    <button class="btn-link" role="link">&larr;Back to Front Page</button>
  </a>
<?php } ?>

<section class="display-box">

  <div class="display-header">
    <h2><?php echo $session->is_admin() ? 'Create User' : 'Sign Up'; ?></h2>

  </div>

  <?php echo display_errors($user->errors);
  ?>

  <div class="display-content">

    <form action="<?php echo url_for('/admin/users/new.php'); ?>" method="post">



      <?php include_once 'form_fields.php'; ?>

      <div class="button-bar">
        <!-- TODO change text in button when user or admin -->
        <input class="button btn-success" type="submit" value="Create User">
      </div>
  </div>
  </form>


</section>

<?php include_once SHARED_PATH . '/footer.php'; ?>