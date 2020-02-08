<?php

// Check to see if user is logged in
function require_login()
{
  global $session;

  if (!$session->is_logged_in()) {
    redirect_to(url_for('/admin/login.php'));
  }
}

// Check to see if it is an admin logged in
function require_admin_role()
{
  global $session;
  if (!$session->is_admin()) {
    redirect_to(url_for('/admin/login.php'));
  }
}

// Display errors on the page
function display_errors($errors = array())
{
  $output = '';

  if (!empty($errors)) {
    $output .= '<div class="errors">';
    $output .= 'Please fix the flowing errors:';
    $output .= '<ul>';
    foreach ($errors as $error) {
      $output .= '<li>' . h($error) . '</li>';
    }
    $output .= '</ul>';
    $output .= '</div>';
  }
  return $output;
}
