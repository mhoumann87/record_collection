<?php require_once '../../../private/initialize.php'; ?>

<?php
// TODO set $page_title based on role
//if (admin) {
$page_title = 'Edit User';
//} else {
//$page_title = 'Edit account';
//}

// Check to see an id is included in URL, else go back
// TODO set redirect based on role
if (!isset($_GET['id'])) {
  //if (admin) {
  redirect_to(url_for('/admin/users/index.php'));
  //} else {
  //redirect_to(url_for('/index.php));
  //}
}

// Get the is from the URL
$id = $_GET['id'];

// Find user in database, else go back

$user = User::find_by_id(h($id));

// TODO change redirect based on role
if ($user === false) {
  //if (admin) {
  redirect_to(url_for('/admin/users/index.php'));
  //} else {
  //redirect_to(url_for('index.php'));
  //}
}

if (is_post_request()) {
  // POST request, "collect" info from user input
} else {
  // GET request, show the form
}
?>

<?php include_once SHARED_PATH . '/admin_header.php'; ?>

<!-- if role is admin show this button -->
<a href="<?php echo url_for('/admin/users/index.php'); ?>">
  <button class="btn-link">&larr;Back To List</button>
</a>

<!-- If role is user, show this button -->
<!-- 
  <a href="<?php //echo url_for('/index.php); 
            ?>">
  <button class="btn-link">&larr;Back To Front Page</button>
</a>
-->

<?php include_once SHARED_PATH . '/admin_footer.php'; ?>