<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* This page is only for administrators. I am keeping it in here for now
* but it shouldn't be possible to delete an album, it is far to destructive 
* for the rest of the site if that happends. 
*/

require_admin_role();

// Get the id from the URL, if there isn't send an id,
// redirect the user to albums/index.php
$id = $_GET['id'] ?? '';

if (!$id) {
  redirect_to('/admin/albums/index.php');
}

// Find the album in the database
$album = Album::find_by_id($id);
if (empty($album))
  redirect_to(url_for('/admin/albums/index.php'));

// If it is a post request, the user wants to delete the album
// if it is a get request we just show the album, no need to do
// anything
if (is_post_request()) {

  // We need to check if there is an image file connected
  // to this album
  if ($album->image == '') {
    // No image file, we just delete the album, set a message,
    // redirect the user to albums/index.php
    $album->delete();
    $session->message('Album was deleted sussessfully');
    redirect_to(url_for('/admin/albums/index.php'));
  } else {
    // We have an image file, so we have to delete that first

    // First we have to make an empty instance of an image
    $image = new Image('', '');
    // Then we try to delete the image file
    $result = $image->delete_uploaded_image($album->get_table_name(), $album->image);
    // If the image was deleted
    if ($result == 1) {
      // Delete the abbum in the database, set a message for user
      // and redirect the user to album/index.php
      $album->delete();
      $session->message($album->title . ' by ' . $album->show_artist_name() . ' and image was deleted');
      redirect_to(url_for('/admin/albums/index.php'));
    } else {
      // Image couldn't be deleted, show error message to user
      $album->errors[] = 'Image could not be deleted';
    }
  }
}
?>

<?php include SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/albums/index.php') ?>">
  <button class="btn-link" role="link">&larr; Back to List</button>
</a>

<section class="display-box">

  <?php if ($album->image_link != '') { ?>

    <div class="display-header-image">
      <img src="<?php echo h($album->image_link); ?>" alt="<?php echo $album->title . ' by ' . $album->show_artist_name(); ?>" />
    </div>

  <?php } elseif ($album->image) { ?>
    <div class="display-header-image">
      <img src="<?php echo url_for('/assets/images/albums/' . h($album->image)); ?>" alt="<?php echo $album->title . ' by ' . $album->show_artist_name(); ?>" />
    </div>
  <?php } else { ?>
    <div class="display-header">
      <h3><?php echo $album->title . ' by ' . $album->show_artist_name(); ?></h3>
    </div>
  <?php } ?>

  <div class="display-content">

    <h3><?php echo h($album->title); ?></h3>

    <p>By <?php echo $album->show_artist_name(); ?></p>

    <div class="delete-post">
      Do you really want to delete <?php echo h($album->title); ?>?
    </div>

    <div class="button-bar">

      <form action="<?php echo url_for('/admin/albums/delete.php?id=' . h(u($album->id))); ?>" method="post">
        <input type="submit" class="button btn-danger" name="submit" value="Yes, delete album" />
      </form>

      <a href="<?php echo url_for('/admin/albums/index.php'); ?>">
        <button class="btn-success" role="link">No, back to list</button>
      </a>

    </div>

  </div>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>