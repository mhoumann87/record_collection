<?php require_once "../../../private/initialize.php"; ?>

<?php

require_admin_role();

$page_title = 'Admin Area - Formats Home';

$formats = Format::find_all();
?>

<?php include SHARED_PATH . '/header.php'; ?>

<a href="<?php echo url_for('/admin/formats/new.php'); ?>">
  <button class="btn-link">Create New Format</button>
</a>

<section class="index-pages">

  <?php foreach ($formats as $format) { ?>

    <article class="card">

      <div class="card-header">
        <h3><?php echo h($format->name); ?></h3>
      </div>

      <div class="card-description">
        <p>ID: <?php echo h($format->id); ?></p>
        <p>Name: <?php echo h($format->name); ?></p>
      </div>

      <div class="button-bar-more">

        <a href="<?php echo url_for('/admin/formats/show.php?id=' . h(u($format->id))); ?>">
          <button class="btn-link" role="link">Show</button>
        </a>

        <a href="<?php echo url_for('/admin/formats/edit.php?id=' . h(u($format->id))); ?>">
          <button class="btn-link" role="link">Edit</button>
        </a>

        <a href="<?php echo url_for('/admin/formats/delete.php?id=' . h(u($format->id))); ?>">
          <button class="btn-danger" role="link">Delete</button>
        </a>

      </div>

    </article>

  <?php } ?>

</section>

<?php include_once SHARED_PATH . '/footer.php'; ?>