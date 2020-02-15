<?php require_once '../../../private/initialize.php'; ?>

<?php

/*
* This page requires you to be logged in
*/

require_login();

if ($session->is_admin()) {
  $page_title = 'Admin Area - Create Artist';
} else {
  $page_title = 'Create Artist';
}

if (is_post_request()) {
} else {
  $artist = new Artist;
} // is_post_request()
