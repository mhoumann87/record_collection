<?php

class Grade extends DatabaseObject
{

  static protected $table_name = 'grades';
  static protected $db_columns = [
    'id',
    'value',
    'short',
    'definition',
    'image'
  ];

  public $allowed_tags = [
    '<br>',
    '<p>',
    '<h1>',
    '<h2>',
    '<h3>',
    '<h4>'
  ];

  public $id;
  public $value;
  public $short;
  public $definition;
  public $image;

  public function __construct($args = [])
  {
    $this->value = $args['value'] ?? '';
    $this->definition = $args['difinition'] ?? '';
  }

  public function get_table_name()
  {
    return self::$table_name;
  }

  public function shorten_definition()
  {
    if (strlen($this->definition) > 100) {
      return substr($this->definition, 0, 100) . '...';
    } else {
      return $this->definition;
    }
  }

  // Remove html tags not cleared in $allowed_tags
  public function clear_html_input($text)
  {
    $allowed_tags = implode('', $this->allowed_tags);
    return strip_tags($text, $allowed_tags);
  }

  // Validate the input
  protected function validate()
  {
    // TODO Add validation functions
  } // validate()

}// class
