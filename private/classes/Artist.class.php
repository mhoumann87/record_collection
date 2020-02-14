<?php

class Artist extends DatabaseObject
{

  static protected $table_name = 'artists';
  static protected $db_columns = [
    'id',
    'bandname',
    'the_first',
    'firstname',
    'lastname',
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

  public $id;
  public $bandname;
  public $the_first;
  public $firstname;
  public $lastname;
  public $image;
  public $profile;
  public $website;
  public $amazon_link;

  public function __construct($args = [])
  {
    $this->bandname = $args['bandname'] ?? '';
    $this->the_first = $args['the_first'] ?? 0;
    $this->firstname = $args['firstname'] ?? '';
    $this->lastname = $args['lastname'] ?? '';
    $this->image = $args['image'] ?? '';
    $this->profile = $args['profile'] ?? '';
    $this->website = $args['website'] ?? '';
    $this->amazon_link = $args['amazon_link'] ?? '';
  }

  public function display_name()
  {
    if (isset($this->bandname)) {
      if (isset($this->the_first)) {
        return "The {$this->bandname}";
      } else {
      }
    } else {
      return "{$this->firstname} {$this->lastname}";
    }
  }
} // class
