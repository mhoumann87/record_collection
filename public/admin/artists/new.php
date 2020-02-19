<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* This page requires you to be logged in
*/

require_login();

if ($session->is_admin()) {
  $page_title = 'Admin Area - Create Artist';
} else {
  $page_title = 'Create Artist';
}

if (is_post_request()) {

  // If it is a POST request, instanciate a new article with
  // the information from the user input.
  $args = $_POST['artist'];
  $artist = new Artist($args);

  // prepare the article for upload
  $artist->set_sorted_name();

  // Check to see if there are any errors in the input
  $valid = $artist->check_validation();

  if (empty($valid)) {
    // The artist passed validation, check to see if an image is uploaded
    if ($_FILES[$artist->for_image_upload]['name']['image'] === '') {
      // No image uploaded, so we just save the article in the database
      $result = $artist->save();
      $set_id = $article->id;

      // If the article were uploaded, redirect to show.php
      if ($result === true) {
        $session->message("Artist was created successfully");
        redirect_to(url_for('/admin/artists/show.php?id=' . h(u($set_id))));
      } // if ($result === true)
    } else { // $_FILES
      // An image is uploaded, and we make an instance to the image
      $image = new Image($_FILES);
      // Set the variables that don't come from the image file
      $image->prepare_upload($artist->max_megabytes, $artist->get_table_name(), $artist->for_image_upload);
      // Try to upload the image
      $result = $image->upload_image();
      // If there are errors in the upload, result is an array and we can show the errors
      if (is_array($result)) {
        // Set the artist errors to the result
        $artist->errors[] = $result;
      } else { // if (is_array($result))
        // If there are no errors, save the article with the link to the image
        $artist->image = $result;

        $result = $artist->save();
        $set_id = $artist->id;
        // If the article were uploaded redirect to show.php
        if ($result === true) {
          $session->message('Image uploaded and artist created successfully');
          redirect_to(url_for('/admin/artists/show.php?id=' . h(u($set_id))));
        }
      } // else if (is_array($result))
    }
  } else { // empty($valid)
    // The artist didn't pass validation, so we display the errors,
    // This happens automaticly, this is just to keep me sane 
  } // else empty($valid)
} else { // is_post_request()
  // If it is a GET request, just show the form with an empty artist
  $artist = new Artist;
} // else is post_request()

?>

<?php include SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/artists/index.php'); ?>">
  <button class="btn-link" role="link">&larr; Back To List</button>
</a>

<section class="display-box">

  <div class="display-header">
    <h2>Create Artist</h2>
  </div>

  <div class="display-content">

    <form action="<?php echo url_for('/admin/artists/new.php'); ?>" method="post" enctype="multipart/form-data">

      <?php include_once 'form_fields.php'; ?>

      <div class="button-bar">
        <input type="submit" name="submit" class="button btn-success" value="Create Artist" />
      </div>

    </form>

  </div>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>