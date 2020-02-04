<?php require_once '../../../private/initialize.php'; ?>

<?php
$page_title = 'Grades Front Page';

$grades = Grade::find_all();

?>

<?php include SHARED_PATH . '/admin_header.php'; ?>
<a href="<?php echo url_for('/admin/grades/new.php'); ?>">
  <button class="btn-link" role="link">Create New</button>
</a>

<section class="index-pages">
  <?php foreach ($grades as $grade) { ?>
    <article class="card">
      <div class="card-header">
        <h3><?php echo h(ucfirst($grade->value)); ?></h3>
        <h3><?php echo h($grade->short); ?></h3>
      </div>
      <div class="description">
        <div class="difinition">
          <?php echo $grade->shorten_definition(); ?>
        </div>
        <div class="button-bar">
          <a href="<?php echo url_for('/admin/grades/show.php?id=' . $grade->id); ?>">
            <button class="btn-link" role="link">Show</button></a>
          <a href="<?php echo url_for('/admin/grades/edit.php?id=' . $grade->id); ?>">
            <button class="btn-link" role="link">Edit</button></a></a>
          <a href="<?php echo url_for('/admin/grades/delete.php?id=' . $grade->id); ?>"> <button class="btn-danger" role="link">Delete</button></a></a>
        </div>
      </div>
    </article>
  <?php } ?>

</section>


<?php include SHARED_PATH . '/admin_footer.php' ?>