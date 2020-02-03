<?php require_once '../../../private/initialize.php'; ?>

<?php

// TODO Set a if admin for page title
//if (is_admin) {
// $page_title = 'Create New User';
//} else {
$page_title = 'Sign Up';
// }
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
    //$session->message("User was created successfully");
    redirect_to(url_for('/admin/users/show.php?id=' . $new_id));
  } else {
    // Show errors
  }
} else {
  // GET request
  $user = new User;
} // if

?>

<?php include_once SHARED_PATH . '/admin_header.php'; ?>

<!-- TODO Only show this button to admins -->
<a href="<?php echo url_for('/admin/users/index.php'); ?>">
  <button class="btn-link" role="link">&larr;Back to List</button>
</a>

<section class="input-page">

  <?php echo display_errors($user->errors);
  ?>

  <form action="<?php echo url_for('/admin/users/new.php'); ?>" method="post">

    <div class="form-box">

      <?php include_once 'form_fields.php'; ?>

      <div class="button-box">
        <!-- TODO change text in button when user or admin -->
        <input class="button btn-success" type="submit" value="Create User">
      </div>
    </div>
  </form>


</section>

<?php include_once SHARED_PATH . '/admin_footer.php'; ?>