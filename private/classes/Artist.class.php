<?php

class Artist extends DatabaseObject
{

  static protected $table_name = 'artists';
  static protected $db_columns = [
    'id',
    'firstname',
    'lastname',
    'sorting',
    'image',
    'profile',
    'website',
    'amazon_link'
  ];
  public $allowed_tags = [
    '<br>',
    '<p>',
    '<h1>',
    '<h2>',
    '<h3>',
    '<h4>',
    '<h5>',
    '<h6>',
  ];

  // The max image size for artists
  public $max_megabytes = 2;

  public $id;
  public $firstname;
  public $lastname;
  protected $sorting;
  public $image;
  public $profile;
  public $website;
  public $amazon_link;

  // Variable to set the image uploads
  public $for_image_upload = 'artist';

  public function __construct($args = [])
  {
    $this->firstname = $args['firstname'] ?? '';
    $this->lastname = $args['lastname'] ?? '';
    $this->image = $args['image'] ?? '';
    $this->profile = $args['profile'] ?? '';
    $this->website = $args['website'] ?? '';
    $this->amazon_link = $args['amazon_link'] ?? '';
  }

  // Set the $sortting variable
  public function set_sorted_name()
  {
    if ($this->lastname != '') {
      $this->sorting = "{$this->lastname}, {$this->firstname}";
    } else {
      $firstname = ucfirst($this->firstname);
      if (strpos($firstname, 'The') !== false) {
        $this->sorting = substr($this->firstname, 4);
      } else {
        $this->sorting = $this->firstname;
      }
    }
  }

  public function display_name()
  {
    if (!isset($this->lastname)) {
      return $this->firstname;
    } else {
      return "{$this->firstname} {$this->lastname}";
    }
  }

  // The only required field is name
  protected function validate()
  {
    $this->errors = [];

    if (is_blank($this->firstname)) {
      $this->errors[] = 'First name can not be blank';
    }
    return $this->errors;
  }

  // Function to check input is valid
  public function check_validation()
  {
    return $this->validate();
  }

  public function get_table_name()
  {
    return self::$table_name;
  }
} // class
