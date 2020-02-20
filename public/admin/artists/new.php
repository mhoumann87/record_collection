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

  // If it is a POST request, instanciate a new article with
  // the information from the user input.
  $args = $_POST['artist'];
  $artist = new Artist($args);

  $artist->set_sorted_name();

  var_dump($artist);
} else { // if (is_post_request())
  // It is a GET request, and we just show the empty form
  // with an empty Artist
  $artist = new Artist;
} // else if (is_post_request())

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

    <form action="<?php echo url_for('/admin/artists/new.php'); ?>" method="post" enctype="multipart/form-data">

      <?php include_once 'form_fields.php'; ?>

      <div class="button-bar">
        <input type="submit" name="submit" class="button btn-success" value="Create Artist" />
      </div>

    </form>

  </div>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>