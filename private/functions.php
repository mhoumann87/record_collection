<?php

// Set URL for the root of the server
function url_for($script_path)
{
  // Add the leading'/' if it is not present
  if ($script_path[0] != '/') {
    $script_path = '/' . $script_path;
  }
  return WWW_ROOT . $script_path;
}

// Redirect to another URL
function redirect_to($location)
{
  header('Location: ' . $location);
  exit();
}
