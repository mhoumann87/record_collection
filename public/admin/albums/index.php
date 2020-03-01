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

<section class="display-all-albums">

  <?php foreach ($albums as $album) { ?>
    <a href="<?php echo url_for('/admin/albums/show.php?id=' . h(u($album->id))); ?>">

      <article class="album-card">


        <div class="card-front">

          <?php if ($album->image_link != '') { ?>

            <div class="card-image">
              <img src="<?php echo h($album->image_link); ?>" alt="<?php echo h($album->title) . ' by ' . $album->show_artist_name(); ?>" />
            </div>

          <?php } elseif ($album->image != '') { ?>
            <div class="card-image">
              <img src="<?php echo url_for('/assets/images/albums/' . h($album->image)); ?>" alt="<?php echo h($album->title) . ' by ' . $album->show_artist_name(); ?>" />
            </div>
          <?php } else { ?>

            <div class="card-text-only">
              <h3><?php echo h($album->title); ?></h3>
              <p>By: <?php echo $album->show_artist_name(); ?></p>
            </div>

          <?php } ?>
        </div>

      </article>
    </a>
  <?php } // foreach 
  ?>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>