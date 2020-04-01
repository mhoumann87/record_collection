<?php require_once '../../../private/initialize.php'; ?>

<?php
/*
* This page can only be seen if user is logged in and
* it is the users wishliat
*/
require_login();

// Get the id from the URL or set it to empty
$id = $_GET['id'] ?? '';
// If the id is empty then return the user to the wishlist
if (!$id) {
  redirect_to(url_for('/admin/wishlist/index.php'));
}
// Get the wishlist from the database
$wishlist = Wishlist::find_by_id(h($id));
// If there are no wishlist item with this id
// send the user back to the list
if ($wishlist === false) {
  redirect_to(url_for('/admin/wishlist/index.php'));
}

// Make sure it is the owner of the wishlist that are
// accessing it
if ($wishlist->user_id != $session->user_id) {
  // The "owner" of the wishlist is not the same
  // as the current user.
  // This shouldn't be possible, but we are just 
  // being extra careful fight now
  redirect_to(url_for('/admin/wishlist/index.php'));
} else {
  // This is the rightful "owner" and we are just moving on

  // Find the record
  $record = Record::find_by_id($wishlist->record_id);
  $page_title = 'Edit ' . $record->get_title_and_artist();
  // If it is a POST request, we update the wishlist
  if (is_post_request()) {
    // Get the input (only able to change format here)
    $args = $_POST['wishlist'];
    // Merge the new info with the old
    $wishlist->merge_attributes($args);
    // Save the new wishlist to the database
    $result = $wishlist->save();

    // When item is updated redirect to index
    if ($result === true) {
      $session->message('Whislist item is updated successfully');
      redirect_to(url_for('/admin/wishlist/index.php'));
    }
  } else {
    // It is a GET request so we just have the instance 
    // of the wishlist, that we set up in the beginning
  }
} // if ($wishlist->user_id != $session->user_id) {

?>

<?php include SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/wishlist/index.php'); ?>">
  <button class="btn-link">Back To List</button>
</a>

<section class="display-box">

  <div class="display-header-no-margin">
    <h2>Edit <?php echo $record->get_title_and_artist(); ?></h2>
  </div>

  <?php echo $record->display_record_image(); ?>

  <?php echo display_errors($wishlist->errors); ?>

  <div class="display-content">

    <h3><?php echo h($record->show_artist_name()); ?></h3>
    <h3>By <?php echo h($record->show_artist_name()); ?></h3>

    <form action="<?php echo url_for('/admin/wishlist/edit.php?id=' . h(u($id))); ?>" method="post">

      <?php include 'form_fields.php'; ?>

      <div class="button-bar">

        <input class="button btn-success" type="submit" value="Edit Item" />

        <button class="btn-success" role="link">Add Album to Collection</button>

        <button class="btn-danger" role="link">Delete from Wishlist</button>

      </div>

    </form>

  </div>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>