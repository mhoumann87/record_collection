<?php require_once '../../../private/initialize.php'; ?>

<?php
$page_title = 'Grades Home';

$grades = Grade::find_all();
var_dump($grades);
?>



<?php include SHARED_PATH . '/admin_header.php'; ?>

<h2>Grades Front Page</h2>

<section class="show-all">


</section>


<?php include SHARED_PATH . '/admin_footer.php' ?>