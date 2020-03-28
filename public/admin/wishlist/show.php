<?php require_once '../../../private/initialize.php'; ?>

<?php

require_login();

$page_title = 'Show Wishlist Item';

$id = $_GET['id'] ?? '';

if (!$id) {
  redirect_to(url_for('/admin/wishlist/index.php'));
}

$wishlist = Wishlist::find_by_id(h($id));

var_dump($wishlist);

?>

<?php include SHARED_PATH . '/header.php'; ?>

<h1><?php echo $page_title; ?></h1>

<?php include SHARED_PATH . '/footer.php'; ?>