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

  <?php //echo display_errors($user->errors); 
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