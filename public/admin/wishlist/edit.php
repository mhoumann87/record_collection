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

$record = Record::find_by_id($wishlist->record_id);

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

<section class="display-content">

  <div class="display-box">

    <?php echo $record->display_record_image(); ?>


    <div class="display-content">

      <h3><?php echo h($record->title); ?></h3>

      <p>By: <?php echo h($record->show_artist_name()); ?></p>

      <div class="info">
        <?php echo $record->information; ?>
      </div>

      <form action="<?php echo url_for('/admin/wishlist/edit.php?id=' . h(u($wishlist->id))); ?>" method="post">

        <?php include 'form_fields.php'; ?>

        <div class="button-bar">

          <input class="button btn-success" type="submit" name="submit" value="Edit Record" />

      </form>

      <a href="<?php echo url_for('/admin/collection/new.php?id=' . h(u($wishlist->id))); ?>">
        <button class="btn-success">Add To Your Collection</button>
      </a>
    </div>



  </div>



  </div>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>