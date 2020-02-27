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