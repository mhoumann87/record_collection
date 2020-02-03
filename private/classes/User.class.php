<?php

class User extends DatabaseObject
{

  static protected $table_name = 'users';
  static protected $db_columns = [
    'id',
    'email',
    'hashed_password',
    'username',
    'is_admin',
    'security_code',
    'created',
    'last_logged_in'
  ];

  public $id;
  public $email;
  protected $hashed_password;
  public $username;
  public $is_admin;
  public $password;
  public $confirm_password;
  protected $security_code;
  protected $created;
  protected $last_logged_in;
  protected $password_required = true;

  public function __construct($args = [])
  {
    $this->email = $args['email'] ?? '';
    $this->username = $args['username'] ?? '';
    $this->hashed_password = $args['hashed_password'] ?? '';
    $this->is_admin = $args['is_admin'] ?? 0;
    $this->password = $args['password'] ?? '';
    $this->confirm_password = $args['confirm_password'] ?? '';
    $this->security_code = $args['security_code'] ?? '';
    $this->created = $args['created'] ?? '';
    $this->last_logged_in = $args['last_logged_in'] ?? '';
  }

  // Function to validate input from user
  protected function validate()
  {

    $this->errors = [];

    // Validate email field
    if (is_blank($this->email)) {
      $this->errors[] = "Email can not be blank";
    } elseif (!has_valid_email_format($this->email)) {
      $this->errors[] = 'Please enter a valid email address';
    } elseif (!has_unique_entries('email', $this->email, $this->id ?? 0)) {
      $this->errors[] = 'Email is allready in database';
    }

    // Validate username field
    if (is_blank($this->username)) {
      $this->errors[] = 'Username can not be blank';
    } elseif (!has_unique_entries('username', $this->username, $this->id ?? 0)) {
      $this->errors[] = 'Username is allready in the database';
    }

    // Validate password
    if ($this->password_required) {

      if (is_blank($this->password)) {
        $this->errors[] = 'Password can not be blank';
      } elseif (!has_length($this->password, array('min' => 8))) {
        $this->errors[] = 'Password must be at least 8 characters';
      }

      if (is_blank($this->confirm_password)) {
        $this->errors[] = 'Confirm password can not be blank';
      } elseif ($this->confirm_password !== $this->password) {
        $this->errors[] = 'Confirm password and password has to be the same';
      }
    }
  }

  protected function set_hashed_password()
  {
    $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  public function verify_password($password)
  {
    return password_verify($password, $this->hashed_password);
  }

  protected function create()
  {
    $this->set_hashed_password();
    return parent::create();
  }

  public function set_created_at()
  {
    $this->created = time();
  }

  // Database call to check uniqueness
  static public function find_by_column($column, $value)
  {
    $sql  = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE " . $column . "='" . self::$db->escape_string($value) . "'";

    $obj_array = static::find_by_sql($sql);
    if (!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }
}// user
