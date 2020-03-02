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
$record = Record::find_by_id(h($id));
if ($record === false) {
  redirect_to(url_for('/index.php'));
}

// Get the artist from the database
$artist = Artist::find_by_id(h($record->artist_id));

// Get the URL the user came from
$from = $_SERVER['HTTP_REFERER'];

// var_dump($artist);
?>

<?php include SHARED_PATH . '/header.php'; ?>

<a href="<?php echo $from; ?>">
  <button class="btn-link" role="link">&larr; Back</button>
</a>

<section class="display-box">

  <?php if ($record->image_link != '') { ?>

    <div class="display-header-image">
      <img src="<?php echo h($record->image_link); ?>" alt="<?php echo $record->title . ' by ' . $artist->display_name(); ?>" />
    </div>

  <?php } elseif ($record->image != '') { ?>
    <div class="display-header-image">
      <img src="<?php echo url_for('/assets/images/' . $record->get_table_name() . '/' . h($record->image)); ?>" alt="<?php echo $record->title . ' by ' . $artist->display_name(); ?>" />
    </div>
  <?php } else { ?>
    <div class="display-header">
      <h2><?php echo $record->title . ' by ' . $artist->display_name(); ?></h2>
    </div>
  <?php } ?>

  <div class="display-content">

    <h3><?php echo h($record->title); ?></h3>

    <p>Released: <?php echo h($record->year); ?></p>


    <p class="artist-name">By <a href="<?php echo url_for('/admin/artists/show.php?id=' . h(u($record->artist_id))) ?>"><?php echo h($artist->display_name()); ?></a></p>


    <div class="info">
      <?php echo $record->information; ?>
    </div>

    <div class="button-bar">
      <a href="<?php echo $from; ?>">
        <button class="btn-success" role="link">Ok</button>
      </a>

      <?php if ($session->is_logged_in()) { ?>

        <a href="<?php echo url_for('/admin/albums/edit.php?id=' . h(u($record->id))); ?>">
          <button class="btn-link" role="link">Edit Album</button>
        </a>

      <?php } ?>

      <?php if ($session->is_admin()) { ?>
        <a href="<?php echo url_for('/admin/albums/delete.php?id=' . h(u($record->id))); ?>">
          <button class="btn-danger" role="link">Delete Album</button>
        </a>

      <?php } ?>

    </div>

  </div>

</section>

<section class="show-albums">

  <?php

  $records = Record::find_by_field_and_sort('artist_id', $artist->id, 'year');

  foreach ($records as $item) {

    if ($item->id === $record->id) {
      continue;
    } else {

  ?>
      <a href="<?php echo url_for('/admin/records/show.php?id=' . h(u($item->id))); ?>">
        <div class="album-card">

          <?php if ($item->image_link != '') { ?>
            <img src="<?php echo h($item->image_link); ?>" alt="<?php echo h($item->title) . ' by ' . $artist->display_name(); ?>" />
          <?php } elseif ($item->image != '') { ?>
            <img src="<?php echo url_for('/assets/images/' . $item->get_table_name() . '/' . h($item->image)); ?>" alt="<?php echo h($item->title) . ' by ' . $artist->display_name(); ?>" />
          <?php } else { ?>
            <div class="show-album-no-image">
              <p><?php echo $item->title; ?></p>
              <p>By: <?php echo h($artist->display_name()); ?></p>
            </div>
          <?php } ?>
        </div>
      </a>
    <?php } ?>
  <?php } ?>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>