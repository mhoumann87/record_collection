<?php require_once "../../../private/initialize.php"; ?>

<?php

/*
* Everyone can see this page, but you have to be logged in 
* to add new posts or edit existing post, and very important, you have 
* to be an administrator to able to delete posts!
*/

if ($session->is_admin()) {
  $page_title = 'Admin Area - Artists Home';
} else {
  $page_title = 'All Artists';
}

$artists = Artist::find_all();

//var_dump($artists);

?>

<?php include SHARED_PATH . '/header.php'; ?>

<?php if ($session->is_logged_in()) { ?>
  <a href="<?php echo url_for('/admin/artists/new.php'); ?>">
    <button class="btn-link">Create New</button>
  </a>
<?php } ?>

<section class="index-page-grid">


  <?php foreach ($artists as $artist) { ?>

    <article class="card-artist">

      <div class="card-top">
        <?php if ($artist->image != '') { ?>
          <a href="<?php echo url_for('admin/artists/show.php?id=' . h(u($artist->id))) ?>">
            <div class="card-image-artist">
              <div class="card-image-artist-box">
                <img src="<?php echo h($artist->image); ?>" alt="Image of <?php echo h($artist->display_name()); ?>" />
              </div>
              <div class="card-image-overlay">
                <h2><?php echo h($artist->display_name()); ?></h2>
              </div>
            </div>
          </a>
        <?php } else { ?>
          <div class="card-header">
            <h3><?php echo h($artist->display_name()); ?></h3>
          </div>
        <?php } ?>
      </div>

      <div class="card-description">

        <div class="card-description-header">
          <h3><?php echo $artist->display_name(); ?></h3>
        </div>

        <div class="card-description-profile">
          <?php echo $artist->profile != '' ? '<div>' . shorten_text($artist->profile, 150) . '</div>' : ''; ?>
        </div>

        <div class="card-description-links">
          <?php echo $artist->website != '' ? '<a href="' . $artist->website . '" target="_blank">Official Website</a>' : ''; ?>

          <?php echo $artist->amazon_link != '' ? '<a href="' . $artist->amazon_link . '" target="_blank">Search on Amazon</a>' : ''; ?>
        </div>

        <div class="button-bar">

          <a href="<?php echo url_for('/admin/artists/show.php?id=' . h(u($artist->id))); ?>">
            <button class="btn-link" role="link">Show Artist</button>
          </a>

          <?php if ($session->is_logged_in()) { ?>
            <a href="<?php echo url_for('/admin/artists/edit.php?id=' . h(u($artist->id))); ?>">
              <button class="btn-link" role="link">Edit Artist</button>
            </a>
          <?php } ?>

          <?php if ($session->is_admin()) { ?>
            <a href="<?php echo url_for('/admin/artists/delete.php?id=' . h(u($artist->id))); ?>">
              <button class="btn-danger" role="link">Delete Artist</button>
            </a>
          <?php } ?>

        </div>

      </div>

    </article><!-- End card -->

  <?php } ?>
  <!-- End card -->

</section>

<?php include SHARED_PATH . '/footer.php'; ?>