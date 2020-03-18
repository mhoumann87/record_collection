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

  var_dump($args);
}



?>

<?php include SHARED_PATH . '/header.php'; ?>

<form action="<?php echo url_for('/admin/wishlist/new.php?id=' . h(u($id))); ?>" method="post">


  <input type="text" name="wishlist[test]" />

  <input type="submit" value="submit" />


</form>

<?php include SHARED_PATH . '/footer.php'; ?>