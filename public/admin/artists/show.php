<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* Everybody can see this page, but only users that are
* logged in con move on to the edit page, and only admins
* can move on to the delete page.
 */

// Get id from URL
$id = $_GET['id'] ?? '';

// If no id is send, redirect to all artists

if (!$id) {
  redirect_to(url_for('/admin/artists/index.php'));
}

// Get the artist
$artist = Artist::find_by_id(h($id));

// If no artist is found, redirect to all artists
if (empty($artist)) {
  redirect_to(url_for('/admin/artists/index.php'));
}

if (!$session->is_admin()) {
  $page_title = 'Admin Area - Show ' . $artist->display_name();
} else {
  $page_title = 'Show ' . $artist->display_name();
}

$image_path = '/assets/images/' . $artist->get_table_name() . '/';
//var_dump($artist);

?>

<?php include SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/artists/index.php'); ?>">
  <button class="btn-link" role="link">&larr; Back To List</button>
</a>

<section class="display-box">

  <?php if ($artist->image != '') { ?>

    <div class="image-artist">
      <img class="img-background" src="<?php echo url_for($image_path . h($artist->image)); ?>" alt="<?php echo $artist->display_name(); ?>" alt="" />


      <div class="img-profile-box">
        <img class="img-profile" src="<?php echo url_for($image_path . h($artist->image)); ?>" alt="<?php echo $artist->display_name(); ?>" />
      </div>
    </div>

  <?php } elseif ($artist->image_link != '') { ?>
    <div class="image-artist">
      <img class="img-background" src="<?php echo h($artist->image_link); ?>" alt="" />


      <div class="img-profile-box">
        <img class="img-profile" src="<?php echo h($artist->image_link); ?>" alt="<?php echo $artist->display_name(); ?>" />
      </div>
    </div>

  <?php } else { ?>
    <div class="display-header">
      <h2><?php echo h($artist->display_name()); ?></h2>
    </div>
  <?php } ?>

  <div class="display-content">

    <h3><?php echo h($artist->display_name()); ?></h3>

    <div><?php echo $artist->profile; ?></div>

    <?php if ($artist->website != '') { ?>
      <p><a href="<?php echo h($artist->website); ?>" target="_blank">Oficial Website</a></p>
    <?php } ?>

    <?php if ($artist->amazon_link != '') { ?>
      <p><a href="<?php echo h($artist->amazon_link); ?>" target="_blank">Search on Amazon</a></p>
    <?php } ?>


    <div class="button-bar">

      <a href="<?php echo url_for('/admin/artists/index.php'); ?>">
        <button class="btn-success" role="link">Ok</button>
      </a>

      <?php if ($session->is_logged_in()) { ?>

        <a href="<?php echo url_for('/admin/artists/edit.php?id=' . h(u($artist->id))); ?>">
          <button class="btn-link" role="link">Edit Artist</button>
        </a>

        <a href="<?php echo url_for('/admin/albums/new.php?id=' . h(u($artist->id))); ?>">
          <button class="btn-link" role="link">Create New Album</button>
        </a>

      <?php } ?>

      <?php if ($session->is_admin()) { ?>
        <a href="<?php echo url_for('/admin/artists/delete.php?id=' . h(u($artist->id))); ?>">
          <button class="btn-danger" role="link">Delete Artist</button>
        </a>
      <?php } ?>

    </div>

  </div>

</section>

<section class="show-albums">

  <?php

  $albums = Album::find_by_field_and_sort('artist_id', $artist->id, 'year');

  foreach ($albums as $album) {

  ?>
    <a href="<?php echo url_for('/admin/albums/show.php?id=' . h(u($album->id))); ?>">
      <div class="album-card">

        <?php if ($album->image_link != '') { ?>
          <div class="artist-show-albums-image">
            <img src="<?php echo h($album->image_link); ?>" alt="<?php echo h($album->title) . ' by ' . $artist->display_name(); ?>" />
          </div>
        <?php } elseif ($album->image != '') { ?>
          <div class="artist-show-albums-image">
            <img src="<?php echo url_for('/assets/images/albums/' . h($album->image)); ?>" alt="<?php echo h($album->title) . ' by ' . $artist->display_name(); ?>" />
          </div>
        <?php } else { ?>
          <div class="artist-show-albums-text">
            <p><?php echo $album->title; ?></p>
          </div>
        <?php } ?>
      </div>
    </a>
  <?php } ?>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>