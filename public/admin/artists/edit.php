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

  /*
  * For this to work right, we have to check the informations that are in
  * the database allready and compare them to the changes the user have made.
  * - Have the user uploaded a new image and are there an image allready in the 
  *   database or are there a link for an image there, we have to delete the old
  *   and insert the new info.
  * - If the user have added an image link, we have to check if an image has to be
  *   deleted or we just have to update the image link
  * - If the user hasn't added any image imformation, we just have to update the artist  
   */
  /*   var_dump($artist);
  echo '<br>';
  var_dump($args); */

  // check to see if user has updated $image_link
  if ($args['image_link'] != '') {
    //echo 'image_link updated';

    // The user have uploaded a new $image_link, 
    // check to see if we have an image in the database
    if ($artist->image != '') {
      // We have an image, delete it the database
      // and also delete it in the folder

      // We need to make an empty instance of an image to
      // "get access" to the Image class
      $image = new Image('', '');
      // Delete the image in the folder using the function in Image class
      // The function delete_uploaded_image() requires the dir and the image name
      $photo_deleted = $image->delete_uploaded_image($artist->get_table_name(), $artist->image);

      // Check to see it image file is successfully deleted
      if ($photo_deleted == 1) {
        // Deletion was successful, update the database

        // Inset the changes from the input
        $artist->merge_attributes($args);
        // Set the name used for sorting
        $artist->set_sorted_name();
        // Set image in the database to an empty string
        $artist->image = '';
        // Update the database
        $result = $artist->save();

        // if update was successfull set message and return to show.php
        // else it will automatically display the errors
        if ($result === true) {
          $session->message('Artist updated successfully');
          redirect_to(url_for('/admin/artists/show.php?id=' . h(u($artist->id))));
        }
      }
    } else {
      // We don't have an image we just update the artist.
      // If we have an image_link in the database it will
      // be updated too
      $artist->merge_attributes($args);
      $artist->set_sorted_name();
      $result = $artist->save();
    }
  } elseif ($_FILES[$artist->for_image_upload]['name']['image'] != '') {
    //echo 'image file is uploaded';
    // The user have uploaded a new image file, 
    // we create an instance of the uploaded Image
    $image = new Image($_FILES, $artist->for_image_upload);
    $image->prepare_upload($artist->max_megabytes, $artist->get_table_name());

    // Check to see if there are an image in the "system" all ready 
    if ($artist->image != '') {
      // We have an image file uploaded all ready
      // var_dump($image);
      // First we have to delete the image file in the directory
      $photo_deleted = $image->delete_uploaded_image($artist->get_table_name(), $artist->image);
      if ($photo_deleted == 1) {
        //echo 'photo deleted';
        // Upload the new image file
        $result = $image->upload_image();
        // Check to see if there are any errors in the upload
        if (is_array($result)) {
          // If upload fails, the $result will be an array of errors, we just display them
          //var_dump($result);
          $article->errors[] = $result;
        } else {
          // No errors we just update the database with info about the new image
          $artist->merge_attributes($args);
          $artist->set_sorted_name();
          $artist->image = $result;
          $result = $artist->save();

          if ($result === true) {
            // If database is updated, show success message and redirect user to show.php
            $session->message('Image uploaded and artist updated successfully');
            redirect_to(url_for('/admin/artists/show.php?id=' . h(u($artist->id))));
          }
        }
      } else {
        $artist->erorrs[] = 'Image could not be deleted.';
      }
    } else {
      // Just upload the image file and update the database
      // If there is a link for an extern image file, it will be
      // overwritten with an empty string
      //echo 'No image in database';

      $result = $image->upload_image();

      if (is_array($result)) {
        // Upload failed, $result is an array of errors, we just add the to $artist->errors[]
        $artist->errors[] = $result;
      } else {
        // The image is uploaded, and we just update the database
        $artist->merge_attributes($args);
        $artist->set_sorted_name();
        $artist->image = $result;
        $result = $artist->save();

        // If update is successful, we set an message and redirect user to show.php
        if ($result === true) {
          $session->message('Image uploaded and artist updated successfully');
          redirect_to(url_for('/admin/artists/show.php?id=' . h(u($artist->id))));
        }
      }
    }
  } else {
    // No image information is uploaded, so we just update the database

    // If there is an image_link all ready, it will be overwritten, so we have to save it
    $save_image_link = '';
    if ($artist->image_link != '') {
      $save_image_link = $artist->image_link;
    }
    $artist->merge_attributes($args);
    $artist->set_sorted_name();
    $artist->image_link = $save_image_link;
    $result = $artist->save();

    if ($result === true) {
      $session->message('Artist updated successfully');
      redirect_to(url_for('/admin/artists/show.php?id=' . h(u($artist->id))));
    }
  }
} // if (is_post_request())

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