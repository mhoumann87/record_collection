<?php require_once '../../../private/initialize.php' ?>

<?php

$page_title = 'All Albums';

/*
* Everybody can see this page, but you have to be logged in
* to create a new album, edit the album and you have to be
* an admin to delete the album 
*/

$artists = Artist::find_all_and_sort('sorting');
//var_dump($albums);

?>

<?php include SHARED_PATH . '/header.php'; ?>

<section class="index-page-grid">

  <?php foreach ($artists as $artist) { ?>

    <h3><?php echo h($artist->display_name()); ?></h3>
    <?php

    $albums = Album::find_by_field_and_sort('artist_id', $artist->id, 'year');

    foreach ($albums as $album) {

    ?>



      <div class="card">

        <?php if ($album->image != '') { ?>

          <div class="card-header-image">
            <a href="<?php echo url_for('/admin/albums/show.php?id=' . h(u($album->id))); ?>">
              <img src="<?php echo url_for('/assets/images/albums/' . h($album->image)); ?>" alt="<?php echo h($artist->display_name()) . ': *' . h($album->title); ?>" />
            </a>
          </div>

        <?php } elseif ($album->image_link != '') { ?>

          <div class="card-header-image">
            <a href="<?php echo url_for('/admin/albums/show.php?id=' . h(u($album->id))); ?>">
              <img src="<?php echo h($album->image_link); ?>" alt="<?php echo h($artist->display_name()) . ': *' . h($album->title); ?>" />
            </a>
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

  <?php } ?>
</section>
<?php include SHARED_PATH . '/footer.php'; ?>