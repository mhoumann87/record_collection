<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* You have to be logged in to see this page, and you have to be
* an administrator to see the delete button 
*/

require_login();

// Get he id from the URL, if no id send user to records/index.php
$id = $_GET['id'] ?? '';

if (!$id) {
  redirect_to(url_for('/admin/records/index.php'));
  //echo 'no id';
}

// Find the album in the database, if no album, redirect to records/index.php

$record = Record::find_by_id(h($id));

if (empty($record)) {
  redirect_to(url_for('/admin/records/index.php'));
  //echo 'no album in database';
}

$page_title = 'Edit ' . $record->title . ' by ' . $record->show_artist_name();

// If it is a POST request, "collect" input and update database
// It it is a GET request just show the info allreadu in the database
if (is_post_request()) {
  $args = $_POST['record'];
  // var_dump($args);

  // If the album is cleared by an administrator, 
  // store the admin id in the database
  if ($args['show_record'] == 1) {
    $record->set_cleared_by($session->user_id);
  }

  // Check to see if an image file is being uploaded
  if ($_FILES[$record->for_image_upload]['name']['image'] != '') {
    // echo 'image uploaded';
    // Check to see we have an image file in the system

    // We create an instance of the image
    $image = new Image($_FILES, $record->for_image_upload);
    // Add the imfo that doesn't comes from the image file
    $image->prepare_upload($record->max_megabytes, $record->get_table_name());

    if ($record->image != '') {
      // We have an image file, so we delete it

      $deleted_image = $image->delete_uploaded_image($record->get_table_name(), $record->image);

      if ($deleted_image == 1) {
        // The image was deleted successfully, so we upload the new one

        $result = $image->upload_image();

        if (is_array($result)) {
          // Upload failed and we take the array of errors and display them
          $record->errors[] = $result;
        } else {
          // The image is uploaded and we update the database
          $record->merge_attributes($args);
          // If the record is updated, set cleared_by to an empty string
          // and mart the record to be cleared again
          if ($args['show_record'] == 0 && $record->show_record == 0) {
            $record->reset_show_and_cleared();
          }
          $record->prepare_for_upload($record->artist_id, $session->user_id);
          $record->image = $result;
          $result = $record->save();

          if ($result == true) {
            $session->message('Old image deleted, new image uploaded and album updated successfully');
            redirect_to(url_for('/admin/records/index.php'));
          }
        }
      }
    } else {
      // We don't have an image allready so we just
      // upload the image and update the database.
      // If there are an image_link in the database,
      // it will automatically be deleted

      $result = $image->upload_image();
      if (is_array($result)) {
        // Upload failed, and $result is returning an array of the erors
        $record->errors[] = $result;
      } else {
        // Image uploaded successfully and we update the database
        $record->merge_attributes($args);
        // If the record is updated, set cleared_by to an empty string
        // and mart the record to be cleared again
        if ($args['show_record'] == 0 && $record->show_record == 0) {
          echo 'Cleared input';
          $record->reset_show_and_cleared();
        }
        $record->prepare_for_upload($record->artist_id, $session->user_id);
        $record->image = $result;
        $result = $record->save();

        if ($result == true) {
          $session->message('Image uploaded and album updated successfully');
          redirect_to(url_for('/admin/records/index.php'));
        }
      }
    }
  } elseif ($args['image_link'] != '') {
    // echo 'new image link is uploaded';
    // There is a new image_link uploaded, check to see if
    // we have an image file for this album
    if ($record->image != '') {
      // We have an image file

      // Create an empty instance of an image
      $image = new Image('', '');
      // Delete the empty image to delete the image file  
      // in the image folder
      $image_deleted = $image->delete_uploaded_image($record->get_table_name(), h($record->image));

      if ($image_deleted == 1) {
        // The image is deleted and we can update database
        $record->merge_attributes($args);
        // If the record is updated, set cleared_by to an empty string
        // and mart the record to be cleared again
        if ($args['show_record'] == 0 && $record->show_record == 0) {
          echo 'Cleared input';
          $record->reset_show_and_cleared();
        }
        $record->prepare_for_upload($record->artist_id, $session->user_id);
        $record->image = '';
        $result = $record->save();

        if ($result == true) {
          $session->message('Image deleted and album is updated successfully');
          redirect_to(url_for('/admin/records/index.php'));
        }
      } else {
        // The image couldn't be deleted and we just show an error message
        $record->errors[] = 'Image could not be deleted';
      }
    } else {
      // No image file in the system, just update the database
      $record->merge_attributes($args);
      // If the record is updated, set cleared_by to an empty string
      // and mart the record to be cleared again
      if ($args['show_record'] == 0 && $record->show_record == 0) {
        echo 'Cleared input';
        $record->reset_show_and_cleared();
      }
      $record->prepare_for_upload($record->artist_id, $session->user_id);
      $result = $record->save();

      if ($result == true) {
        $session->message('Album updated successfully');
        redirect_to(url_for('/admin/records/index.php'));
      }
    }
  } else {
    // echo 'no image uploaded';
    // We just update the database, but we have to be sure that
    // if an image_link is in the databeas we resubmit it
    $save_image_link = '';

    if ($record->image_link != '') {
      $save_image_link = $record->image_link;
    }

    $record->merge_attributes($args);
    // If the record is updated, set cleared_by to an empty string
    // and mart the record to be cleared again
    echo $args['show_record'] . '<br>';
    echo $record->show_record;
    if ($args['show_record'] == 0 && $record->show_record == 0) {
      $record->reset_show_and_cleared();
    }
    $record->prepare_for_upload($record->artist_id, $session->user_id);
    $record->image_link = $save_image_link;
    $result = $record->save();

    if ($result === true) {
      $session->message('Album is updated successfully');
      redirect_to(url_for('/admin/records/index.php'));
    }
  }
} else {
  // Just show the form with info from the database
}

?>

<?php include SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/records/show.php?id=' . h(u($id))); ?>">
  <button class="btn-link" role="link">&larr; Back to Album</button>
</a>

<section class="display-box">

  <?php if ($record->image_link != '') { ?>

    <div class="display-header-image">
      <img src="<?php echo h($record->image_link); ?>" alt="<?php echo h($record->title) . ' by ' . $record->show_artist_name(); ?>" />
    </div>

  <?php } elseif ($record->image != '') { ?>

    <div class="display-header-image">
      <img src="<?php echo url_for('/assets/images/' . $record->get_table_name() . '/' . h($record->image)); ?>" alt="<?php echo h($record->title) . ' by ' . $record->show_artist_name(); ?>" />
    </div>

  <?php } else { ?>

    <div class="display-header">
      <h3><?php echo h($record->title . ' by ' . $record->show_artist_name()); ?></h3>
    </div>

  <?php } ?>

  <?php echo display_errors($record->errors); ?>

  <div class="display-content">

    <div class="record-info">

      <p><a href="<?php echo url_for('/admin/artists/show.php?id=' . h(u($record->artist_id))); ?>">
          <?php echo $record->show_artist_name(); ?>
        </a></p>

      <?php if ($session->is_admin()) { ?>

        <p>Created by: <?php echo $record->display_created_by(); ?></p>
        <?php echo $record->display_cleared_by() ? '<p>Cleared by: ' . $record->display_cleared_by() . '</p>' : ''; ?>
        <p>Created <?php echo date('j/n Y', $record->created_at); ?></p>
        <?php echo $record->updated_at ? '<p>Updated at: ' . date('j/n Y', $record->updated_at) . '</p>' : ''; ?>


      <?php } ?>

    </div>

    <form action="<?php echo url_for('/admin/records/edit.php?id=' . h(u($record->id))); ?>" method="post" enctype="multipart/form-data">

      <?php include_once 'form_fields.php'; ?>

      <div class="button-bar">
        <input type="submit" class="button btn-success" name="submit" value="Edit Album" />
      </div>

    </form>

  </div>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>