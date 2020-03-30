<?php

class Record extends DatabaseObject
{
  static protected $table_name = 'records';
  static protected $db_columns = [
    'id',
    'created_by',
    'artist_id',
    'title',
    'year',
    'information',
    'image_link',
    'image',
    'show_record',
    'cleared_by',
    'created_at',
    'updated_at'
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
  protected $created_by;
  public $artist_id;
  public $title;
  public $year;
  public $information;
  public $image_link;
  public $image;
  public $show_record;
  protected $cleared_by;
  public $created_at;
  public $updated_at;

  public $for_image_upload = 'record';

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

  // Set and get created_by
  public function set_created_by($id)
  {
    $this->created_by = $id;
  }

  public function display_created_by()
  {
    $user = User::find_by_id($this->created_by);
    return $user->username;
  }

  // Get and set cleared by
  public function set_cleared_by($id)
  {
    $this->cleared_by = $id;
  }

  public function display_cleared_by()
  {
    if ($this->cleared_by) {
      $user = User::find_by_id($this->cleared_by);
      return $user->username;
    } else {
      return false;
    }
  }

  // When record is updated, reset cleared_by and show_record
  public function reset_show_and_cleared()
  {
    $this->cleared_by = 0;
    $this->show_record = 0;
    return $this->cleared_by;
  }

  public function get_title_and_artist()
  {
    return "{$this->title} by {$this->show_artist_name()}";
  }

  // Find the name of the artist this album connects to
  public function show_artist_name()
  {
    $artist = Artist::find_by_id($this->artist_id);
    return h($artist->display_name());
  }

  // Function to output for image
  public function display_record_image()
  {
    if ($this->image_link != '') {
      return
        '<div class="display-header-image">' .
        '<img src="' . $this->image_link . '" alt="' . $this->get_title_and_artist() . '">' .
        '</div>';
    } elseif ($this->image != '') {
      $path_to_image = url_for('/assets/images/' . self::$table_name . '/' . $this->image);
      return
        '<div class="display-header-image">' .
        '<img src="' . $path_to_image . '" alt="' . $this->get_title_and_artist() . '">' .
        '</div>';
    } else {
      return
        '<div class="display-header"><h2>' . $this->get_title_and_artist() . '</h2></div>';
    }
  }

  // Get all input ready for upload
  public function prepare_for_upload($artist, $user)
  {
    $this->year = (int) $this->year;
    $this->artist_id = (int) $artist;
    $this->set_created_by($user);
    $this->information = $this->clear_html_input($this->information);
    self::set_dates();
  }

  // Set the updated and created at dates
  protected function set_dates()
  {
    if (!isset($this->id)) {
      $this->created_at = time();
    } else {
      $this->updated_at = time();
    }
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
