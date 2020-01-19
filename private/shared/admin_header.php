<?php if (!isset($page_title)) {
  $page_title = 'Admin Area';
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
  <header class="admin-header">
    <h1>My Record Collection</h1>
    <p>Admin Area - <?php echo $page_title; ?></p>
  </header>