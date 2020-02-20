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
  // Set name to use for sorting
  $artist->set_sorted_name();
  // Check to see if validation will pass
  $valid = $artist->check_validation();
  //  var_dump($valid);
  if (empty($valid)) {
    // The user input is valid, check to see if an image is uploaded
    if ($_FILES[$artist->for_image_upload]['name']['image'] === '') {
      // TODO No image is uploaded, so we just save the artist
      echo 'No Image';
    } else { //if ($_FILES[$artist->for_image_upload]['name']['image'] === '')
      // echo 'Image Uploaded';
      // An image is uploaded and we make an insrance of the image
      $image = new Image($_FILES, $artist->for_image_upload);
      // Set the variables that is not contained in the image file
      $image->prepare_upload($artist->max_megabytes, $artist->get_table_name());
      // Try to upload the image
      var_dump($image);
      //$result = $image->upload_image();
      //var_dump($result);
    } // else if ($_FILES[$artist->for_image_upload]['name']['image'] === '')
  } else { // if (empty($valid))
    // The input is not valid, so we just show the filled form with
    // the error message. This will happend automaticly, this is just 
    // to keep my head in the right place.
  } // else if(empty($valid))
} else { // if (is_post_request())
  // It is a GET request, and we just show the empty form
  // with an empty Artist
  $artist = new Artist;
} // else if (is_post_request())

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