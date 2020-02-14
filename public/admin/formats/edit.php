<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* This area is for administrators only.
* The content is just user ad "service"
* the main pages 
*/

$page_title = 'Admin Area - Edit Format';

require_admin_role();

$id = $_GET['id'] ?? '';

if (!$id) {
  redirect_to(url_for('/admin/formats/index.php'));
}

$format = Format::find_by_id(h($id));

if (empty($format)) {
  redirect_to(url_for('/admin/formats/index.php'));
}

// Check to see if it is a post reguest
if (is_post_request()) {

  // Get what is in the input fields
  $args = $_POST['format'];

  // Merge the new and old input and save() the post
  $format->merge_attributes($args);
  $result = $format->save();

  //var_dump($result);
  // Check to see if the save() was successful
  if ($result === true) {
    $session->message('Format was updated successfully');
    redirect_to(url_for('/admin/formats/show.php?id=' . h(u($id))));
  } else {
    // show form
  }
}

?>

<?php include_once SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/formats/index.php'); ?>">
  <button class="btn-link" role="link">&larr; Back To List</button>
</a>

<section class="display-box">

  <div class="display-header">
    <h2>Edit Format</h2>
  </div>

  <?php echo display_errors($format->errors); ?>

  <form action="<?php echo url_for('/admin/formats/edit.php?id=' . h(u($id))); ?>" method="post">

    <div class="display-content">

      <?php include_once './form_fields.php'; ?>

      <div class="button-bar-single">
        <input type="submit" class="button btn-success" value="Update Format">
      </div>

    </div>

  </form>


</section>

<?php include_once SHARED_PATH . '/footer.php'; ?>