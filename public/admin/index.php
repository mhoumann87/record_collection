<?php require_once '../../private/initialize.php'; ?>
<p class="no-show" id="imagePath">../../public/assets/images/</p>
<?php
$page_title = 'Admin Area - Not cleared items';

/*
* This page is for admins only
*/

require_admin_role();

$artists = Artist::find_by_field_and_sort('show_artist', 0, 'created_at');

// var_dump($artists);
?>

<?php include_once SHARED_PATH . '/header.php'; ?>

<section class="admin-index">

  <?php if (!empty($artists)) { ?>

    <div class="show-artists">

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
    <div class="show-artists">

      <div class="no-artists">
        <p>No artists waiting at the moment</p>
      </div>

    </div>
  <?php } // !empty(artist)
  ?>

</section>

<?php include_once SHARED_PATH . '/footer.php'; ?>