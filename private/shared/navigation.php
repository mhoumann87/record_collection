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

    <a href="<?php echo url_for('index.php'); ?>">
      <button class="nav-btn <?php echo set_menu_active($_SERVER['REQUEST_URI'], 'public/index.php') ?>" role="link">Home</button>
    </a>

    <a href="<?php echo url_for('/admin/artists/index.php'); ?>">
      <button class="nav-btn <?php

                              if (!$session->is_admin()) {
                                echo set_menu_active($_SERVER['REQUEST_URI'], '/admin/artists/');
                              }
                              ?>" role="link">All Artists</button>
    </a>

    <a href="<?php echo url_for('/all_records.php'); ?>">
      <button class="nav-btn <?php echo set_menu_active($_SERVER['REQUEST_URI'], '/all_records.php') ?>" role="link">All Records</button>
    </a>

    <?php if ($session->is_logged_in()) { ?>
      <a href="<?php echo url_for('/admin/users/show.php?id=' . $_SESSION['user_id']); ?>">
        <button class="nav-btn <?php
                                if (!$session->is_admin()) {
                                  echo set_menu_active($_SERVER['REQUEST_URI'], '/admin/users/');
                                }
                                ?>" role="link">Account</button>
      </a>
    <?php } ?>

    <?php if ($session->is_admin()) { ?>

      <a href="<?php echo url_for('/admin/records/index.php'); ?>">
        <button class="nav-btn <?php echo set_menu_active($_SERVER['REQUEST_URI'], '/admin/records/') ?>" role="link">Albums</button>
      </a>
      <a href="<?php echo url_for('/admin/artists/index.php'); ?>">
        <button class="nav-btn <?php echo set_menu_active($_SERVER['REQUEST_URI'], '/admin/artists/') ?>" role="link">Artists</button>
      </a>
      <a href="<?php echo url_for('/admin/formats/index.php'); ?>">
        <button class="nav-btn <?php echo set_menu_active($_SERVER['REQUEST_URI'], '/admin/formats/') ?>" role="link">Formats</button>
      </a>
      <a href="<?php echo url_for('/admin/grades/index.php'); ?>">
        <button class="nav-btn <?php echo set_menu_active($_SERVER['REQUEST_URI'], '/admin/grades/') ?>" role="link">Grades</button>
      </a>
      <a href="<?php echo url_for('/admin/users/index.php'); ?>">
        <button class="nav-btn <?php echo set_menu_active($_SERVER['REQUEST_URI'], '/admin/users/') ?>" role="link">Users</button>
      </a>

    <?php } ?>

    <?php if ($session->is_logged_in()) { ?>
      <a href="<?php echo url_for('/admin/logout.php'); ?>">
        <button class="nav-btn <?php echo set_menu_active($_SERVER['REQUEST_URI'], '/all_artists.php') ?>" role="link">Logout</button>
      </a>
    <?php } else { ?>

      <a href="<?php echo url_for('/admin/users/new.php'); ?>">
        <button class="nav-btn <?php echo set_menu_active($_SERVER['REQUEST_URI'], '/admin/users/new.php') ?>" role="link">Sign Up</button>
      </a>

      <a href="<?php echo url_for('/admin/login.php'); ?>">
        <button class="nav-btn <?php echo set_menu_active($_SERVER['REQUEST_URI'], '/admin/login.php') ?>" role="link">Login</button>
      </a>
    <?php } ?>
  </nav>

</section>