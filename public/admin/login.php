<?php require_once '../../private/initialize.php';

$page_title = 'Login';

$errors = [];
$username = '';
$password = '';

?>

<?php include_once SHARED_PATH . '/admin_header.php'; ?>
<p class="no-show" id="imagePath">../../public/assets/images/</p>

<section class="input-page">

  <?php echo display_errors($errors); ?>

  <div class="form-box">

    <div class="input-header">
      <h2>Login</h2>
    </div>

    <div class="outer-input-box">

      <form action="login.php" method="post">

        <div class="input-box">
          <label for="username">Username: </label>
          <input type="text" name="username" value="<?php echo h($username); ?>" autofocus>
        </div>

        <div class="input-box">
          <label for="password">Password: </label>
          <input type="password" name="password">
        </div>

        <div class="button-box">
          <input type="submit" class="button btn-success" value="Login">
        </div>

    </div>

    </form>

  </div>

</section>

<?php include_once SHARED_PATH . '/admin_footer.php'; ?>