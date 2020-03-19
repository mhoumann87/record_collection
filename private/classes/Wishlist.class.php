<?php

class Wishlist extends DatabaseObject
{

  static protected $table_name = 'wishlists';
  static protected $db_colomns = [
    'id',
    'user_id',
    'record_id',
    'format_id'
  ];

  public $id;
  public $user_id;
  public $record_id;
  public $format_id;

  public function __construct($args = [])
  {
    $this->user_id = $args['user_id'] ?? '';
    $this->record_id = $args['record_id'] ?? '';
    $this->format_id = $args['format_id'] ?? '';
  }
} // class
