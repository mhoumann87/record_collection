<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* This area is for administrators only.
* The content is just user ad "service"
* the main pages 
*/

require_login();

// Get the id from the URL if it is not there set id to empty
$id = $_GET['id'] ?? '';

if (!$id) {
  redirect_to($_SESSION['is_admin'] == 1 ? url_for('/admin/grades/index.php') : url_for('/index.php'));
}

$grade = Grade::find_by_id($id);

if (empty($grade)) {
  redirect_to($_SESSION['is_admin'] == 1 ? url_for('/admin/grades/index.php') : url_for('/index.php'));
}

if ($_SESSION['is_admin'] == 1) {
  $page_title = 'Admin Area - View Grade';
} else {
  $page_title = 'View Grade ' . h($grade->short);
}
?>

<?php include_once SHARED_PATH . '/header.php'; ?>

<?php if ($session->is_admin()) { ?>
  <a href="<?php echo url_for('/admin/grades/index.php'); ?>">
    <button class="btn-link" role="link">&larr; Back to list</button>
  </a>
<?php } else { ?>
  <a href="<?php echo url_for('/index.php'); ?>">
    <button class="btn-link" role="link">&larr; Back to Front Page</button>
  </a>
<?php } ?>
<section class="display-box">

  <?php if (isset($grade->image)) { ?>

    <div class="display-header-image">
      <h2>Show <?php echo h(ucfirst($grade->value)); ?></h2>
    </div>

    <img src="<?php echo url_for('/assets/images/') . $grade->image; ?>" alt="">
  <?php } else { ?>
    <div class="display-header">
      <h2>Show <?php echo h(ucfirst($grade->value)); ?></h2>
    </div>
  <?php } ?>

  <div class="display-content">

    <h3>Name: <?php echo h(ucfirst($grade->value)); ?></h3>

    <h3>Short: <?php echo h($grade->short); ?></h3>

    <h3>Description:</h3>

    <div class="description">
      <?php echo $grade->definition; ?>
    </div>

    <?php if ($_SESSION['is_admin'] == 1) { ?>

      <div class="button-bar">

        <a href="<?php echo url_for('/admin/grades/index.php'); ?>">
          <button class="btn-success" role="link">Ok</button>
        </a>

        <a href="<?php echo url_for('/admin/grades/edit.php?id=' . $grade->id); ?>">
          <button class="btn-link" role="link">Edit</button>
        </a>

        <a href="<?php echo url_for('/admin/grades/delete.php?id=' . $grade->id); ?>">
          <button class="btn-danger" role="link">Delete</button>
        </a>

      </div>

    <?php } ?>

  </div>

</section>

<?php include_once SHARED_PATH . '/footer.php'; ?>