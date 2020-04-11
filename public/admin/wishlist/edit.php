<?php require_once '../../../private/initialize.php'; ?>

<?php
/*
* This page can only be seen if user is logged in and
* it is the users wishliat
*/
require_login();
// Get the wishlist id from the URL,
// if no id redirect to wishlist/index.php
$wishlist_id = $_GET['id'] ?? '';
if (!$wishlist_id) {
  redirect_to(url_for('/admin/wishlist/index.php'));
}
// Find the wishlist in the database from
// the id in the URL, if no wishlist found
// redirect to wishlist/index.pho
$wishlist = Wishlist::find_by_id($wishlist_id);
// var_dump($wishlist);
if (!$wishlist) {
  redirect_to(url_for('/admin/wishlist/index.php'));
}

// If it is a POST request update the item
// otherwise just show the form with the info
// from the database
if (is_post_request()) {
  echo 'Update database';
} else {
  // Just show the form
}



?>

<?php include SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/wishlist/index.php'); ?>">
  <button class="btn-link" role="link">Back To List</button>
</a>

<?php include SHARED_PATH . '/footer.php'; ?>