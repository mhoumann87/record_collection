<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* You have to be logged in to see this page
*/

require_login();

// You can only get here from the artist page, and then you have an in
// that connects to the artist, if not we just redirect to frontpage for
// a "narmal" user and to the admin/nidex.php if you are an administrator
$artist = $_GET['id'] ?? '';

if ($artist == '') {
  if ($session->is_admin()) {
    redirect_to(url_for('/admin/index.php'));
  } else {
    redirect_to(url_for('/index.php'));
  }
}

if (is_post_request()) {
  $args = $_POST['album'];

  $album = new Album($args);
  $album->prepare_for_upload($artist);

  $valid = $album->check_validation();
  if (empty($valid)) {
    // Validation passed, check to see if an image file is uploaded
    if ($_FILES[$album->for_image_upload]['name']['image'] === '') {
      // echo 'No Image uploaded';
      // No image is uploaded, so we just save the album
      $result = $album->save();
      $set_id = $album->id;
      // If the abmum were saved redirect to show.php
      if ($result === true) {
        $session->message('Album were created successfully');
        redirect_to(url_for('/admin/albums/show.php?id=' . h(u($set_id))));
      }
    } else {
      //echo 'Image is uploaded';
      // An image file is uploaded and we make an instance of the image
      $image = new Image($_FILES, $album->for_image_upload);
      // Set the variables that don't comes from the image file
      $image->prepare_upload($album->max_megabytes, $album->get_table_name());
      // Upload the image file to the directory
      $result = $image->upload_image();
      // Check to see if upload were successful
      if (is_array($result)) {
        // If upload failed, the $result will be an array of errors,
        // and we just pass them on to $article->error_get_last
        $album->errors[] = $result;
      } else {
        // No errors in image upload, save the article with the image name
        $album->image = $result;
        // Save the ablum to the database
        $result = $album->save();
        $set_id = $album->id;
        // If album is saved set success message and redirect to show.php
        if ($result === true) {
          $session->message('Image is uploaded and album is saved successfully');
          redirect_to(url_for('/admin/albums/show.php?id=' . h(u($set_id))));
        }
      }
    }
  } // if (empty($valid))

  // var_dump($album);
} else {
  $album = new Album;
  $album->artist_id = $artist;
}

$page_title = 'Create Album for ' . $album->show_artist_name($artist);
?>

<?php include SHARED_PATH . '/header.php'; ?>

<div class="display-box">

  <div class="display-header">
    <h2>Create New Album</h2>
  </div>

  <div class="display-content">

    <form action="<?php echo url_for('/admin/albums/new.php?id=' . h(u($artist))); ?>" method="post" enctype="multipart/form-data">

      <div class="input-box">
        <p>Artist: <?php echo h($album->show_artist_name($artist)); ?></p>
      </div>

      <?php include_once 'form_fields.php'; ?>

      <div class="button-bar">
        <input type="submit" class="button btn-success" value="Create Album" />
      </div>

    </form>
  </div>
</div>

<?php include SHARED_PATH . '/footer.php'; ?>