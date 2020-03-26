<?php require_once '../../../private/initialize.php'; ?>

<?php

require_login();

$items = Wishlist::find_by_field_and_sort('user_id', $session->user_id, 'added');
var_dump($items);

$page_title = 'My Wish List for ' . $session->username;

?>

<?php include SHARED_PATH . '/header.php'; ?>

<h2>Wishlist for <?php echo $session->username; ?></h2>

<?php if (!empty($items)) {
  foreach ($items as $item) {
?>
    <p>Items in wishlist</p>
    <p>format: <?php echo $item->get_format_for_item();
                ?></p>
  <?php
  }
} else { ?>
  <p>There are no items on the wishlist.</p>

<?php } ?>

<?php ?>
<?php include SHARED_PATH . '/footer.php'; ?>