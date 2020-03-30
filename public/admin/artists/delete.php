<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* This page is only to be accessed by admins.
* Right now I keep this page here, but it shouldn't be
* possible to delete an artist no matter what rights you have,
* it will be were destructive for the whole site.
*/
require_admin_role();

// Get the id from the URL, if no id there set it to blank
$id = $_GET['id'] ?? '';
// Check to see if there is a $id, else send user back to index
if (!isset($id) || $id == '') {
  redirect_to('/admin/artists/index.php');
}
// Find the artist based on the id
$artist = Artist::find_by_id(h($id));
//var_dump($artist);
// If no artist is found $artist will be false and we send 
// the user back to index
if ($artist === false) {
  redirect_to('/admin/artists/index.php');
}

// Set page title based on the found artist
$page_title = "Delete Artist {$artist->display_name()}";

// If it is a post request the user wants the artist deleted
if (is_post_request()) {

  // Check to see if there is an image uploaded for the artist
  if ($artist->image != '') {
    // Make an instance of an empty image
    $image = new Image('', '');
    // Try to delete image
    $result = $image->delete_uploaded_image($artist->get_table_name(), h($artist->image));
    // If the image is deleted
    if ($result == 1) {
      // Delete the artist, set success message and return user to index
      $artist->delete();
      $session->message("{$artist->display_name()} and image was deleted successfully");
      redirect_to(url_for('/admin/artists/index.php'));
    } else {
      // Image couldn't be deleted
      $artist->errors[] = "Image couldn't be deleted.";
    }
  } else { // if ($article->image != '')
    // No image is uploaded, so we just delete the artist

    // Delete the artist
    $artist->delete();

    // Set success message and send user back to index
    $session->message("{$artist->display_name()} was deleted sussecfully");
    redirect_to(url_for('/admin/artists/index.php'));
  } // if ($article->image != '')

} // if (is_post_request())

/*
* No need to check artist is deleted, it should be happening
* automatically and you will see on the index page after.
*/
?>

<?php include SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/artists/index.php'); ?>">
  <button class="btn-link" role="link">&larr; Back To List</button>
</a>

<section class="display-box">

  <?php echo $artist->display_artist_image(); ?>

  <div class="display-content">

    <h2><?php echo h($artist->display_name()); ?></h2>

    <div><?php echo $artist->profile; ?></div>

    <div class="delete-post">
      <h3>Do You Really Want to Delete <?php echo $artist->display_name(); ?></h3>
    </div>

    <div class="button-bar">
      <form action="<?php echo url_for('/admin/artists/delete.php?id=' . h(u($artist->id))); ?>" method="post">
        <input type="submit" class="button btn-danger" name="submit" value="Yes, delete artist" />
      </form>
      <button class="btn-success" role="link">No, back to list</button>
    </div>


</section>

<?php include SHARED_PATH . '/footer.php'; ?>