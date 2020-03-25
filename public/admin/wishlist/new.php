<?php require_once '../../../private/initialize.php'; ?>

<?php

require_login();

$page_title = 'Create new whishlist item';

$id = $_GET['id'] ?? '';

if (!$id) {
  redirect_to(url_for('/all_records.php'));
}

$record = Record::find_by_id(h($id));

if (!$record) {
  redirect_to(url_for('/all_records.php'));
}

if (is_post_request()) {
  $args = $_POST['wishlist'];
  // var_dump($args);
  $wishlist = new Wishlist($args);
  $wishlist->prepare_for_upload();
  $result = $wishlist->save();
  //var_dump($args);

  //var_dump($wishlist);
  //var_dump($result);

  if ($result === true) {
    $session->message('Item added to your wishlist');
    redirect_to(url_for('/admin/wishlist/index.php'));
  }
} else {
  // It is a get request, just make an empty instance of a wishlist
  $wishlist = new Wishlist();
}

?>

<?php include SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/records/show.php?id=' . h(u($record->id))); ?>">
  <button class="btn-link">Back To Album</button>
</a>

<section class="display-box">

  <div class="display-header-no-margin">
    <h2>Add Album to Your Wishlist</h2>
  </div>

  <?php if ($record->image_link != '') { ?>
    <div class="display-header-image">
      <img src="<?php echo h($record->image_link); ?>" alt="<?php echo $record->get_title_and_artist(); ?>" />
    </div>
  <?php } elseif ($record->image != '') { ?>
    <div class="display-header-image">
      <img src="<?php echo url_for('/assets/images/' . $record->get_table_name() . '/' . $record->image); ?>" alt="<?php echo $record->get_title_and_artist(); ?>" />
    </div>
  <?php } else { ?>
    <?php echo ''; ?>
  <?php } ?>

  <?php echo display_errors($wishlist->errors); ?>

  <div class="display-content">

    <h3><?php echo h($record->show_artist_name()); ?></h3>
    <h3>By <?php echo h($record->show_artist_name()); ?></h3>

    <form action="<?php echo url_for('/admin/wishlist/new.php?id=' . h(u($id))); ?>" method="post">

      <?php include 'form_fields.php'; ?>

      <input class="button btn-success" type="submit" value="Add Item" />


    </form>

  </div>

</section>

<?php include SHARED_PATH . '/footer.php'; ?>