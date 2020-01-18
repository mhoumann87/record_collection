<?php require_once '../../../private/initialize.php'; ?>

<?php $page_title = 'Add Grade'; ?> 

<?php

// If it is a get request, just show the form with an empty post

$grade = new Grade;
?>

<?php include SHARED_PATH . '/admin_header.php'; ?>

<?php include SHARED_PATH . '/admin_footer.php'; ?>