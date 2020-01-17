<?php require_once '../../../private/initialize.php'; ?>

<?php
$page_title = 'Grades Home';

$grades = Grade::find_all();

?>



<?php include SHARED_PATH . '/admin_header.php'; ?>

<h2>Grades Front Page</h2>

<section class="show-all">
  <?php foreach ($grades as $grade) { ?>
    <article class="card">
      <h3><?php echo h(ucfirst($grade->value)); ?></h3>
      <div class="description">
        <?php echo $grade->definition; ?>
      </div>
    </article>
  <?php } ?>

</section>


<?php include SHARED_PATH . '/admin_footer.php' ?>