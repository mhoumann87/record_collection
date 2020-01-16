<?php

class Grade extends DatabaseObject
{

  static protected $table_name = 'grades';
  static protected $db_columns = [
    'id',
    'value',
    'definition'
  ];

  public $test = 'test';

  public $id;
  public $value;
  public $definition;

  public function __construct($args = [])
  {
    $this->value = $args['value'] ?? '';
    $this->definition = $args['difinition'] ?? '';
  }

  public function get_table_name()
  {
    return self::$table_name;
  }
}// class
