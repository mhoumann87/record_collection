<section class="navbar">

  <div class="welcome">
    <?php if ($session->is_logged_in()) {
      echo 'Welcome ' . $session->username;
    } else {
      echo '';
    }
    ?>

  </div>

  <nav role="navigation">
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
    <a href="<?php echo url_for('/admin/users/index.php'); ?>">
      <button class="nav-btn" role="link">Users</button>
    </a>

    <?php if ($session->is_logged_in()) { ?>
      <a href="<?php echo url_for('/admin/logout.php'); ?>">
        <button class="nav-btn" role="link">Logout</button>
      </a>
    <?php } else { ?>
      <a href="<?php echo url_for('/admin/login.php'); ?>">
        <button class="nav-btn" role="link">Login</button>
      </a>
    <?php } ?>
  </nav>

</section>