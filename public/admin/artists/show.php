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

?>

<?php include SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/artists/index.php'); ?>">
  <button class="btn-link" role="link">&larr; Back To List</button>
</a>

<section class="display-box">

  <?php if (isset($artist->image)) { ?>

    <div class="image-artist">
      <img class="img-background" src="<?php echo h($artist->image); ?>" alt="<?php echo $artist->display_name(); ?>" alt="" />


      <div class="img-profile-box">
        <img class="img-profile" src="<?php echo h($artist->image); ?>" alt="<?php echo $artist->display_name(); ?>" />
      </div>
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


    <div class="<?php echo $session->is_logged_in() ? 'button-bar-more' : 'button-bar-single'; ?>">

      <a href="<?php echo url_for('/admin/artists/index.php'); ?>">
        <button class="btn-success" role="link">Ok</button>
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

</section>

<?php include SHARED_PATH . '/footer.php'; ?>