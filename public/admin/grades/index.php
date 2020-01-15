<?php require_once '../../../private/initialize.php'; ?>

<?php
$page_title = 'Grades Home';

$grades = Grade::find_all();
?>



<?php include SHARED_PATH . '/admin_header.php'; ?>

<h2>Grades Front Page</h2>

<?php
var_dump($grades);
?>

<?php include SHARED_PATH . '/admin_footer.php' ?>