<?php

ob_start(); // Turn on output buffering

// Assign file paths to PHP constants
// __FILE__ returns the current path to this file
// dirname() returns the path to the parent directory
define("PRIVATE_PATH", dirname(__FILE__));
define("PROJECT_PATH", dirname(PRIVATE_PATH));
define("PUBLIC_PATH", PROJECT_PATH . "/public");
define("SHARED_PATH", PRIVATE_PATH . "/shared");

// Assign the root URL to a PHP constant
// - Do not need to include the domain
// - Use the same document root as webserver
$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public');
$public_end = $public_end + 7;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);

// Add all the files needed for the project
require_once 'db_credentials.php';
require_once 'database_functions.php';
require_once 'functions.php';

$db = db_connect();
