<?php

class Session
{
  public $user_id;
  public $username;
  public $user_role;
  private $last_login;

  public const MAX_LOGIN_AGE = 60 * 60 * 24 * 7; // one week

  public function __construct()
  {
    session_start(); // turn on session when a new session is initialized
    $this->check_stored_login();
  }

  public function login($user)
  {
    if ($user) {
      session_regenerate_id(); // prevent session fixation attacks
      $this->user_id = $_SESSION['user_id'] = $user->id;
      $this->username = $_SESSION['username'] = $user->username;
      $this->user_role = $_SESSION['user_role'] = $user->user_role;
      $this->last_login = $_SESSION['last_login'] = time();
    }
    return true;
  } // login()

  // Check to see if the user is logged in
  public function is_logged_in()
  {
    return isset($this->user_id) && $this->last_login_is_recent();
  } // is_logged_in()

  // Check if user is administrator
  public function is_admin()
  {
    return $this->is_logged_in() && $this->user_role == 'admin';
  } // is_admin()

  // Log user out
  public function logout()
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    unset($_SESSION['user_role']);
    unset($_SESSION['last_login']);
    unset($this->user_id);
    unset($this->username);
    unset($this->user_role);
    unset($this->last_login);

    return true;
  } // logout()

  private function check_stored_login()
  {
    if (isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
      $this->username = $_SESSION['username'];
      $this->user_role = $_SESSION['user-role'];
      $this->last_login = $_SESSION['last_login'];
    }
  } // check_stored_login()

  private function last_login_is_recent()
  {
    if (!isset($this->last_login)) {
      return false;
    } elseif ($this->last_login + self::MAX_LOGIN_AGE < time()) {
      return false;
    } else {
      return true;
    }
  } // last_login_is_recent()

  public function message($msg = "")
  {
    if (!empty($msg)) {
      // this is a set message
      $_SESSION['message'] = $msg;
      return true;
    } else {
      // this is a get message
      return $_SESSION['message'] ?? '';
    }
  } // message()

  public function clear_message()
  {
    unset($_SESSION['message']);
  } // clear_message()
}// class
