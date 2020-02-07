<?php require_once '../../private/initialize.php';

$page_title = 'Login';

$errors = [];
$email = '';
$password = '';

if (is_post_request()) {

  // Get user input
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  // Validate input
  if (is_blank($email)) {
    $errors[] = 'Please enter email';
  } elseif (!has_valid_email_format($email)) {
    $errors[] = "Please enter valid email";
  }

  if (is_blank($password)) {
    $errors[] = 'Please enter password';
  }

  // If input is valid, try to login
  if (empty($errors)) {

    // Try to find user in database
    $user = User::find_by_column('email', $email);

    // Check email and password
    if ($user != false && $user->verify_password($password)) {
      // User logged in

      // Save $last_logged_in
      $user->last_logged_in = time();
      $user->save();

      // Mark user as logged in
      $session->login($user);
    } else {
      $errors[] = 'Email or Password is incorrect';
    }
  }
} // if (is_post_request)

?>

<?php include_once SHARED_PATH . '/admin_header.php'; ?>
<p class="no-show" id="imagePath">../../public/assets/images/</p>

<section class="input-page">

  <div class="form-box">

    <div class="input-header">
      <h2>Login</h2>
    </div>

    <?php echo display_errors($errors); ?>

    <div class="outer-input-box">

      <form action="login.php" method="post">

        <div class="input-box">
          <label for="email">Email: </label>
          <input type="text" name="email" value="<?php echo h($email); ?>" autofocus>
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