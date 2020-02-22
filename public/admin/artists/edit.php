<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* This page requies the user to be logged in, but you have
* to be administrator to see the delete button 
*/

require_login();

// Get the id from the URL or set it to an empty string
$id = $_GET['id'] ?? '';

// If the URL doesn't contain an id, redirect user to index.php
if ($id == '') {
  redirect_to(url_for('/admin/artists/index.php'));
}

// Get the artist from the database
$artist = Artist::find_by_id(h($id));
//var_dump($artist);
// If there are no artist with that id, send user to index.php
if ($artist === false) {
  redirect_to('/admin/artists/index.php');
}

// Set page tiltle based on user role
if ($session->is_admin()) {
  $page_title = 'Admin Area - Edit ' . h($artist->display_name());
} else {
  $page_title = 'Edit ' . h($artist->display_name());
}

if (is_post_request()) {
  // The user submitted changes, collect them in an array
  $args = $_POST['artist'];

  // CHeck to see if an image is uploaded
  if ($_FILES[$artist->for_image_upload]['name']['image'] != '') {
    // There are an image been uploaded
    // Create an instance of the image
    $image = new Image($_FILES, $artist->for_image_upload);
    // Set the variables not included in the image file
    $image->prepare_upload($artist->max_megabytes, $artist->get_table_name());
    // Check to see if there allready are an image uploaded for this artist
    if ($artist->image != '') {
      // There is a image uploaded for this artist
      // Delete this image in the assets folder
      $photo_deleted = $image->delete_uploaded_image($artist->get_table_name(), h($artist->image));
      // Check to controll the image is deleted
      if ($photo_deleted == 1) {
        // Upload the new image and update the artist
        $result = $image->upload_image();
        // Check to see if image is uploaded
        if (is_array($result)) {
          // $result is an array of errors
          $artist->errors[] = $result;
        }
      }
    }
  } // if (is_post_request())
}

?>

<?php include SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/artists/index.php'); ?>">
  <button class="btn-link" role="link">&larr; Back to List</button>
</a>

<section class="display-box">

  <?php if ($artist->image_link != '') { ?>
    <div class="display-header-image">
      <img src="<?php echo h($artist->image_link); ?>" alt="<?php echo h($artist->display_name()); ?>">
    </div>
  <?php } elseif ($artist->image) { ?>
    <div class="display-header-image">
      <img src="<?php echo url_for('/assets/images/artists/' . h($artist->image)); ?>" alt="<?php echo h($artist->display_name()); ?>">
    </div>
  <?php } else { ?>
    <div class="display-header">
      <h2><?php echo h($artist->display_name()); ?></h2>
    </div>
  <?php } ?>

  <div class="display-content">

    <form action="<?php echo url_for('/admin/artists/edit.php?id=' . h(u($artist->id))); ?>" method="post" enctype="multipart/form-data">

      <?php include_once 'form_fields.php'; ?>

      <div class="button-box">
        <input type="submit" class="button btn-success" name="submit" value="Edit Artist" />
      </div>

    </form>

  </div>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>