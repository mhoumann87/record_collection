<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* This page can only be viewed if you are logged in 
*/
require_login();


// Get the id from the URL or set it as empty
$id = $_GET['id'] ?? '';
// If id is empty send user to wishlist/index.php
if (!$id) {
  redirect_to(url_for('/admin/wishlist/index.php'));
}
// Get the Wishlist Object
$wishlist = Wishlist::find_by_id(h($id));
//If there are no Wishlist object send user to wishlist/index.php
if (!$wishlist) {
  redirect_to(url_for('/admin/wishlist/index.php'));
}
// Check to see if it is the users wishlist item else send to frontpage
if ($wishlist->user_id === $session->user_id) {
  // Get the record for this Whislist object
  $record = Record::find_by_id(h($wishlist->record_id));
  // Set page_title if we have a record, else send user to wishlist/index.php
  if ($record != '') {
    $page_title = $record->get_title_and_artist();
  } else {
    redirect_to(url_for('/admin/wishlist/index.php'));
  }
} else {
  redirect_to(url_for('/index.php'));
}

?>

<?php include SHARED_PATH . '/header.php'; ?>

<section class="display-box">

  <?php echo $record->display_record_image(); ?>

  <div class="display-content">

    <h3><?php echo ucfirst(h($record->title)); ?></h3>

    <h3><?php echo ucfirst(h($record->show_artist_name())); ?></h3>

    <div class="info">
      <?php echo $record->information; ?>
    </div>

    <p>Format: <?php echo h($wishlist->get_format_for_item()); ?></p>

    <p>Added to wishlist: <?php echo h($wishlist->get_date_added()); ?></p>

    <div class="button-bar">

      <a href="<?php echo url_for('/admin/collection/add.php?id=' . $wishlist->record_id); ?>">
        <button class="btn-success" role="link">Add Record to Collection</button>
      </a>

      <a href="<?php echo url_for('/admin/wishlist/delete.php?id=' . $wishlist->id); ?>">
        <button class="btn-danger" role="link">Delete from Wishlist</button>
      </a>

    </div>

  </div>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>