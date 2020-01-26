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

  // Check to see if input is valid
  public function check_validation()
  {
    return $this->validate();
  }

  // Validate the input
  protected function validate()
  {
    $this->errors = [];

    if (is_blank($this->value)) {
      $this->errors[] = 'Value can not be blank';
    }

    if (is_blank($this->short)) {
      $this->errors[] = 'Short name can not be blank';
    }

    if (is_blank($this->definition)) {
      $this->errors[] = 'Description can not be blank';
    }

    if (is_blank($this->image)) {
      $this->errors[] = 'Image link can not be blank';
    }
  } // validate()

}// class
