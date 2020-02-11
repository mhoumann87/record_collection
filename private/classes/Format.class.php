<?php

class Format extends DatabaseObject
{

  static protected $table_name = 'formats';
  static protected $db_columns = [
    'id',
    'name'
  ];

  public $id;
  public $name;

  public function __construct($args = [])
  {
    $this->name = $args['name'] ?? '';
  }

  protected function validate()
  {
    $this->errors = [];

    if (is_blank($this->name)) {
      $this->errors[] = "Name can not be blank";
    }
  }
} // class
