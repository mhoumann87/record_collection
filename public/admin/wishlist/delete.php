<?php require_once '../../../private/initialize.php'; ?>

<?php

// You have to be logged in to see this page
require_login();

// Get the id from the URL
$wishlist_id = $_GET['id'] ?? '';
// If no id is sent, redirect to index
if (!$wishlist_id) {
  redirect_to(url_for('/admin/wishlist/index.php'));
}

$record;

// Find the wishlist in the database
$wishlist = Wishlist::find_by_id($wishlist_id);
// var_dump($wishlist);
// If there are no item with this id, 
// redirect to wishlist/index.php
if ($wishlist === false) {
  redirect_to(url_for('/admin/wishlist/index.php'));
} else {
  // Get the record from the database
  $record = Record::find_by_id($wishlist->record_id);
}

var_dump($record);

$page_title = 'Delete ' . h($record->get_title_and_artist());
?>

<?php include SHARED_PATH . '/header.php'; ?>

<h1><?php echo $page_title; ?></h1>

<?php include SHARED_PATH . '/footer.php'; ?>