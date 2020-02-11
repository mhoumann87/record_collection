<?php require_once '../private/initialize.php'; ?>

<?php $page_title = 'Home';
//var_dump($_SESSION);
?>

<?php include SHARED_PATH . '/header.php';
?>

<!-- 
  The relative path to the image directory from this file, 
  only for use in the javascript, that's why it is not shown
  on the page
-->
<p class="no-show" id="imagePath">../public/assets/images/</p>

<h2>This is the frontpage</h2>

<?php include SHARED_PATH . '/footer.php';
?>