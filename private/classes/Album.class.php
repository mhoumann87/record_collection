<?php

class Album extends DatabaseObject
{
  static protected $table_name = 'albums';
  static protected $db_columns = [
    'id',
    'artist_id',
    'title',
    'year',
    'information',
    'image_link',
    'image'
  ];
  protected $allowed_tags = [
    '<br>',
    '<h3>',
    '<h2>',
    '<h1>',
    '<a>',
    '<p>'
  ];

  public $id;
  public $artist_id;
  public $title;
  public $year;
  public $information;
  public $image_link;
  public $image;

  public $for_image_upload = 'album';

  // Size in megabytes images for albums can be
  public $max_megabytes = 2;

  public function __construct($args = [])
  {
    $this->artist_id = $args['artist_id'] ?? '';
    $this->title = $args['title'] ?? '';
    $this->year = $args['year'] ?? '';
    $this->information = $args['information'] ?? '';
    $this->image_link = $args['image_link'] ?? '';
    $this->image = $args['image'] ?? '';
  }

  // Function to send table name further on
  public function get_table_name()
  {
    return self::$table_name;
  }

  // Find the name of the artist this album connects to
  public function show_artist_name()
  {
    $artist = Artist::find_by_id($this->artist_id);
    return h($artist->display_name());
  }

  // Get all input ready for upload
  public function prepare_for_upload($id)
  {
    $this->year = (int) $this->year;
    $this->artist_id = (int) $id;
    $this->information = $this->clear_html_input($this->information);
  }

  // Rules for validation, we just need title and year
  protected function validate()
  {
    $this->errors = [];

    if (is_blank($this->title)) {
      $this->errors[] = 'Please add a title.';
    }
    if (is_blank($this->year)) {
      $this->errors[] = 'Plase add a year';
    }

    return $this->errors;
  }

  // Function to check the validation
  public function check_validation()
  {
    return $this->validate();
  }

  // Remove all html tags we don't want in the database,
  // Quite important as we uptput pure html code from the 
  // database
  public function clear_html_input($text)
  {
    $allowed_tags = implode('', $this->allowed_tags);
    return strip_tags($text, $allowed_tags);
  }
}// class
