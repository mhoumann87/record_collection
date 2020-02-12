<?php if (!isset($page_title)) {
  $page_title = 'My Record Collection';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Record Collection - <?php echo $page_title; ?></title>
  <link rel="stylesheet" href="<?php echo url_for('assets/styles/main.css') ?>">
</head>

<body>
  <header>
    <div class="branding">
      <h1>My Record Collection</h1>

      <p><?php echo $page_title; ?></p>
    </div>
    <div class="image" id="admin-header-image"></div>
    <?php include_once SHARED_PATH . '/navigation.php';
    ?>
  </header>

  <?php echo display_session_message(); ?>

  <main>