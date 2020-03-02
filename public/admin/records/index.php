<?php require_once '../../../private/initialize.php' ?>

<?php

$page_title = 'All Albums';

/*
* Everybody can see this page, but you have to be logged in
* to create a new album, edit the album and you have to be
* an admin to delete the album 
*/

$records = Record::find_all();
//var_dump($records);

?>

<?php include SHARED_PATH . '/header.php'; ?>

<section class="display-all-albums">

  <?php foreach ($records as $record) { ?>
    <a href="<?php echo url_for('/admin/records/show.php?id=' . h(u($record->id))); ?>">

      <article class="album-card">


        <div class="card-front">

          <?php if ($record->image_link != '') { ?>

            <div class="card-image">
              <img src="<?php echo h($record->image_link); ?>" alt="<?php echo h($record->title) . ' by ' . $record->show_artist_name(); ?>" />
            </div>

          <?php } elseif ($record->image != '') { ?>
            <div class="card-image">
              <img src="<?php echo url_for('/assets/images/' . $record->get_table_name() . '/' . h($record->image)); ?>" alt="<?php echo h($record->title) . ' by ' . $record->show_artist_name(); ?>" />
            </div>
          <?php } else { ?>

            <div class="card-text-only">
              <h3><?php echo h($record->title); ?></h3>
              <p>By: <?php echo $record->show_artist_name(); ?></p>
            </div>

          <?php } ?>
        </div>

        <div class="card-back">

          <p class="card-album-title">
            <?php echo h($record->title); ?>
          </p>

          <p class="card-album-artist">
            <?php echo $record->show_artist_name(); ?>
          </p>

        </div>

      </article>
    </a>
  <?php } // foreach 
  ?>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>