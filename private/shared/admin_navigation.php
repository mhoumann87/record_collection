<nav class="admin-nav" role="navigation">
  <a href="<?php echo url_for('/admin/index.php'); ?>">
    <button class="nav-btn" role="link">Home</button>
  </a>
  <a href="<?php echo url_for('/admin/records/index.php'); ?>">
    <button class="nav-btn" role="link">Records</button>
  </a>
  <a href="<?php echo url_for('/admin/artists/index.php'); ?>">
    <button class="nav-btn" role="link">Artists</button>
  </a>
  <a href="<?php echo url_for('/admin/formats/index.php'); ?>">
    <button class="nav-btn" role="link">Formats</button>
  </a>
  <a href="<?php echo url_for('/admin/grades/index.php'); ?>">
    <button class="nav-btn" role="link">Grades</button>
  </a>
</nav>