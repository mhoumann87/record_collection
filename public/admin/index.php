<?php require_once '../../private/initialize.php'; ?>

<p class="no-show" id="imagePath">../../public/assets/images/</p>

<?php

$page_title = 'Admin Area - Not cleared items';

/*
* This page is for admins only
*/

require_admin_role();

$artists = Artist::find_by_field_and_sort('show_artist', 0, 'created_at');
$records = Record::find_by_field_and_sort('show_record', 0, 'created_at');

// var_dump($artists);
?>

<?php include_once SHARED_PATH . '/header.php'; ?>

<section class="admin-index">

  <div class="show-artists">

    <?php if (!empty($artists)) { ?>

      <div class="show-artists-header">
        <h3>Artists waiting to be cleared</h3>
      </div>

      <div class="show-artists-grid">

        <?php foreach ($artists as $artist) { ?>
          <div class="show-artist-card">

            <p><?php echo h($artist->display_name()); ?></p>
            <p>Created by: <?php echo h($artist->display_username()); ?></p>
            <p>Created:
              <?php echo $artist->created_at != '' ? date('j/n Y', $artist->created_at) : 'No Date Info'; ?></p>

            <div class="button-bar">
              <a href="<?php echo url_for('/admin/artists/edit.php?id=' . h(u($artist->id))); ?>">
                <button class="btn-success" role="link">Clear Artist</button>
              </a>
            </div>
          </div>

        <?php } // foreach 
        ?>

      </div>

  </div>

<?php } else { ?>

  <div class="nothing-to-show">
    <p>No artists waiting at the moment</p>
  </div>


<?php } // !empty(artist)
?>

</div>

<div class="show-records">

  <?php if (!empty($records)) { ?>

    <div class="show-records-header">
      <h3>Albums waiting to be cleared</h3>
    </div>

    <div class="show-records-grid">

      <?php foreach ($records as $record) { ?>


        <div class="show-record-card">
          <a href="<?php echo url_for('/admin/records/show.php?id=' . h(u($record->id))); ?>">
            <?php if ($record->image_link != '') { ?>
              <img src="<?php echo h($record->image_link); ?>" alt="<?php echo h($record->get_title_and_artist()); ?>" />
            <?php } elseif ($record->image != '') { ?>
              <img src="<?php echo url_for('/assets/images/' . $record->get_table_name() . '/' . h($record->image)) ?>" alt="<?php echo h($record->get_title_and_artist()); ?>" />
            <?php } else { ?>
              <div class="no-record-image">
                <?php echo h($record->get_title_and_artist()); ?>
              </div>
            <?php } ?>
          </a>
        </div>

      <?php } // foreach $records 
      ?>

    </div> <!-- show-records-grid -->

  <?php } else { // !empty($records)
  ?>

    <div class="nothing-to-show">
      <p>No albums waiting at the moment</p>
    </div>

  <?php } // else !empty($records) 
  ?>

</div> <!-- show-rwcords -->

<aside class="artist-index-aside">

  <h1>How to use this page</h1>

</aside>

</section>

<?php include_once SHARED_PATH . '/footer.php'; ?>