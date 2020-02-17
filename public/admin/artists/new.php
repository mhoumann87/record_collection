<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* This page requires you to be logged in
*/

require_login();

if ($session->is_admin()) {
  $page_title = 'Admin Area - Create Artist';
} else {
  $page_title = 'Create Artist';
}

if (is_post_request()) {
} else {
  $artist = new Artist;
} // is_post_request()

?>

<?php include SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/artists/index.php'); ?>">
  <button class="btn-link" role="link">&larr; Back To List</button>
</a>

<section class="display-box">

  <div class="display-header">
    <h2>Create Artist</h2>
  </div>

  <div class="display-content">

    <form action="<?php echo url_for('/admin/artists/new.php'); ?>" method="post" enctype="multipart/form-data>">

      <?php include_once './form_fields.php'; ?>


      <div class="button-bar">
        <input type="submit" name="submit" class="button btn-success" value="Create Artist" />
      </div>

    </form>

  </div>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>