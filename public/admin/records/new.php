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
  $args = $_POST['record'];

  $record = new Record($args);
  $record->prepare_for_upload($artist);

  $valid = $record->check_validation();
  if (empty($valid)) {
    // Validation passed, check to see if an image file is uploaded
    if ($_FILES[$record->for_image_upload]['name']['image'] === '') {
      // echo 'No Image uploaded';
      // No image is uploaded, so we just save the album
      $result = $record->save();
      $set_id = $record->id;
      // If the abmum were saved redirect to show.php
      if ($result === true) {
        $session->message('Album were created successfully');
        redirect_to(url_for('/admin/records/show.php?id=' . h(u($set_id))));
      }
    } else {
      //echo 'Image is uploaded';
      // An image file is uploaded and we make an instance of the image
      $image = new Image($_FILES, $record->for_image_upload);
      // Set the variables that don't comes from the image file
      $image->prepare_upload($record->max_megabytes, $record->get_table_name());
      // Upload the image file to the directory
      $result = $image->upload_image();
      // Check to see if upload were successful
      if (is_array($result)) {
        // If upload failed, the $result will be an array of errors,
        // and we just pass them on to $article->error_get_last
        $record->errors[] = $result;
      } else {
        // No errors in image upload, save the article with the image name
        $record->image = $result;
        // Save the ablum to the database
        $result = $record->save();
        $set_id = $record->id;
        // If album is saved set success message and redirect to show.php
        if ($result === true) {
          $session->message('Image is uploaded and album is saved successfully');
          redirect_to(url_for('/admin/records/show.php?id=' . h(u($set_id))));
        }
      }
    }
  } // if (empty($valid))

  // var_dump($record);
} else {
  $record = new Record;
  $record->artist_id = $artist;
}

$page_title = 'Create Album for ' . $record->show_artist_name($artist);
?>

<?php include SHARED_PATH . '/header.php'; ?>

<div class="display-box">

  <div class="display-header">
    <h2>Create New Album</h2>
  </div>

  <?php echo display_errors($record->errors); ?>

  <div class="display-content">

    <form action="<?php echo url_for('/admin/records/new.php?id=' . h(u($artist))); ?>" method="post" enctype="multipart/form-data">

      <div class="input-box">
        <p>Artist: <?php echo h($record->show_artist_name($artist)); ?></p>
      </div>

      <?php include_once 'form_fields.php'; ?>

      <div class="button-bar">
        <input type="submit" class="button btn-success" value="Create Album" />
      </div>

    </form>
  </div>
</div>

<?php include SHARED_PATH . '/footer.php'; ?>