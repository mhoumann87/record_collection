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
    $this->confirm_password = $args['confirm_password'];
    $this->security_code = $args['security_code'] ?? '';
    $this->created = $args['created'] ?? '';
    $this->last_logged_in = $args['last_logged_in'];
  }
}// user
