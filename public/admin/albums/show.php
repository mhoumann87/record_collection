<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* Everybody can see this page, but you have to be a user to see
* the edit button, and admin to see the delete button
*/

// Get the id from the URL, if no id is send, return the user to the frontpage
$id = $_GET['id'] ?? '';
if (!$id) {
  redirect_to(url_for('/index.php'));
}

// Get the ablum from the database, if no album found, return the user to the frontpage
$album = Album::find_by_id(h($id));
if ($album === false) {
  redirect_to(url_for('/index.php'));
}

// Get the artist from the database
$artist = Artist::find_by_id(h($album->artist_id));

// Get the URL the user came from
$from = $_SERVER['HTTP_REFERER'];

// var_dump($artist);
?>

<?php include SHARED_PATH . '/header.php'; ?>

<a href="<?php echo $from; ?>">
  <button class="btn-link" role="link">&larr; Back</button>
</a>

<section class="display-box">

  <?php if ($album->image_link != '') { ?>

    <div class="display-header-image">
      <img src="<?php echo h($album->image_link); ?>" alt="<?php echo $album->title . ' by ' . $artist->display_name(); ?>" />
    </div>

  <?php } elseif ($album->image) { ?>
    <div class="display-header-image">
      <img src="<?php echo url_for('/assets/images/albums/' . h($album->image)); ?>" alt="<?php echo $album->title . ' by ' . $artist->display_name(); ?>" />
    </div>
  <?php } else { ?>
    <div class="display-header">
      <h3><?php echo $album->title . ' by ' . $artist->display_name(); ?></h3>
    </div>
  <?php } ?>

  <div class="display-content">

    <h3><?php echo h($album->title); ?></h3>

    <p>Released: <?php echo h($album->year); ?></p>


    <p class="artist-name">By <a href="<?php echo url_for('/admin/artists/show.php?id=' . h(u($album->artist_id))) ?>"><?php echo h($artist->display_name()); ?></a></p>


    <div class="info">
      <?php echo $album->information; ?>
    </div>

  </div>

</section>

<section class="show-albums">

  <?php

  $albums = Album::find_by_field_and_sort('artist_id', $artist->id, 'year');

  foreach ($albums as $item) {

    if ($item->id === $album->id) {
      continue;
    } else {

  ?>
      <a href="<?php echo url_for('/admin/albums/show.php?id=' . h(u($item->id))); ?>">
        <div class="album-card">

          <?php if ($item->image_link != '') { ?>
            <img src="<?php echo h($item->image_link); ?>" alt="<?php echo h($item->title) . ' by ' . $artist->display_name(); ?>" />
          <?php } elseif ($item->image != '') { ?>
            <img src="<?php echo url_for('/assets/images/albums/' . h($item->image)); ?>" alt="<?php echo h($item->title) . ' by ' . $artist->display_name(); ?>" />
          <?php } else { ?>
            <h3><?php echo $item->title; ?></h3>
          <?php } ?>
        </div>
      </a>
    <?php } ?>
  <?php } ?>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>