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

    <a href="<?php echo url_for('/index.php'); ?>">
      <button class="nav-btn" role="link">Home</button>
    </a>

    <a href="<?php echo url_for('/all_artists.php'); ?>">
      <button class="nav-btn" role="link">All Artists</button>
    </a>

    <a href="<?php echo url_for('/all_records.php'); ?>">
      <button class="nav-btn" role="link">All Records</button>
    </a>

    <?php if ($session->is_logged_in()) { ?>
      <a href="<?php echo url_for('/admin/users/show.php' . $_SESSION['user_id']); ?>">
        <button class="nav-btn" role="link">Account</button>
      </a>
    <?php } ?>

    <?php if ($session->is_admin()) { ?>

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

    <?php } ?>

    <?php if ($session->is_logged_in()) { ?>
      <a href="<?php echo url_for('/admin/logout.php'); ?>">
        <button class="nav-btn" role="link">Logout</button>
      </a>
    <?php } else { ?>

      <a href="<?php echo url_for('/admin/users/new.php'); ?>">
        <button class="nav-btn" role="link">Sign Up</button>
      </a>

      <a href="<?php echo url_for('/admin/login.php'); ?>">
        <button class="nav-btn" role="link">Login</button>
      </a>
    <?php } ?>
  </nav>

</section>