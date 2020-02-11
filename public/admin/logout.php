<?php require_once '../../private/initialize.php';

$role = $_SESSION['is_admin'];

//echo $role;

$session->logout();

if ($role == 1) {
  redirect_to(url_for('/admin/login.php'));
  //echo '<br>Admin';
} else {
  redirect_to(url_for('/index.php'));
  //echo '<br>User';
}
