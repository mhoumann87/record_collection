<?php

class Wishlist extends DatabaseObject
{

  static protected $table_name = 'wishlists';
  static protected $db_columns = [
    'id',
    'user_id',
    'record_id',
    'format_id',
    'added'
  ];

  public $id;
  public $user_id;
  public $record_id;
  public $format_id;
  protected $added;

  public function __construct($args = [])
  {
    $this->user_id = $args['user_id'] ?? '';
    $this->record_id = $args['record_id'] ?? '';
    $this->format_id = $args['format_id'] ?? '';
  }

  // Function to add the infomation not comming from the user
  public function prepare_for_upload()
  {
    self::set_item_added();
  }

  // Get and set when item is added
  public function set_item_added()
  {
    $this->added = time();
  }

  public function get_date_added()
  {
    return date('j/n Y', $this->added);
  }

  public function get_format_for_item()
  {
    $format = Format::find_by_id($this->format_id);
    //return $format;
    return $format->name;
  }
} // class
