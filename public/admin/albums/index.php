<?php require_once '../../../private/initialize.php' ?>

<?php

$page_title = 'All Albums';

/*
* Everybody can see this page, but you have to be logged in
* to create a new album, edit the album and you have to be
* an admin to delete the album 
*/

$albums = Album::find_all();
//var_dump($albums);

?>

<?php include SHARED_PATH . '/header.php'; ?>

<section class="index-page-grid">

  <?php foreach ($albums as $album) {
    $artist = Artist::find_by_id($album->artist_id);
  ?>

    <div class="card">

      <?php if ($album->image != '') { ?>

        <div class="card-header-image">
          <img src="<?php echo url_for('/assets/images/albums/' . h($album->image)); ?>" alt="<?php echo h($artist->display_name()) . ': *' . h($album->title); ?>" />
        </div>

      <?php } elseif ($album->image_link != '') { ?>

        <div class="card-header-image">
          <img src="<?php echo h($album->image_link); ?>" alt="<?php echo h($artist->display_name()) . ': *' . h($album->title); ?>" />
        </div>

      <?php } else { ?>

        <div class="card-header">
          <h3><?php echo h($album->title) . ' by ' . h($artist->display_name()); ?></h3>
        </div>

      <?php } ?>

      <div class="card-description">
        <h3><?php echo $album->title; ?></h3>

        <p class="artist-name"><a href="<?php echo url_for('/admin/artists/show.php?id=' . h(u($artist->id))); ?>"><?php echo h($artist->display_name()); ?></a></p>

        <div class="info"><?php echo $album->information; ?></div>

      </div>

    </div>

  <?php } ?>

</section>
<?php include SHARED_PATH . '/footer.php'; ?>