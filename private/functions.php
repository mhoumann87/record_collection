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

// Encode string for use with URLs as a query string
function u($string = '')
{
  return urlencode($string);
}

function raw_u($string = '')
{
  return rawurldecode($string);
}

// Sanitize the spacial characters by replacing them with HTML code
function h($string = '')
{
  return htmlspecialchars($string);
}

// Redirect to another URL
function redirect_to($location)
{
  header('Location: ' . $location);
  exit();
}

// Check the request type
function is_post_request()
{
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request()
{
  return $_SERVER['REQUEST_METHOD' == 'GET'];
}

// Set menu point as active when on the right page
function set_menu_active($uri, $str)
{
  $class = '';

  if (has_string($uri, $str)) {
    $class = 'active';
  }
  return $class;
}

function shorten_text($text, $length = 100)
{
  if (strlen($text) > $length) {
    return substr($text, 0, $length) . '...';
  } else {
    return $text;
  }
}
