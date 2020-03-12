<?php

class Artist extends DatabaseObject
{

  static protected $table_name = 'artists';
  static protected $db_columns = [
    'id',
    'created_by',
    'firstname',
    'lastname',
    'sorting',
    'image_link',
    'image',
    'profile',
    'show_artist',
    'cleared_by',
    'website',
    'amazon_link',
    'created_at',
    'updated_at'
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
  protected $created_by;
  public $firstname;
  public $lastname;
  protected $sorting;
  public $image_link;
  public $image;
  public $profile;
  public $show_artist;
  protected $cleared_by;
  public $website;
  public $amazon_link;
  public $created_at;
  public $updated_at;


  // Variable to set the image uploads
  public $for_image_upload = 'artist';

  public function __construct($args = [])
  {
    $this->firstname = $args['firstname'] ?? '';
    $this->lastname = $args['lastname'] ?? '';
    $this->image_link = $args['image_link'] ?? '';
    $this->image = $args['image'] ?? '';
    $this->profile = $args['profile'] ?? '';
    $this->show_artist = $args['show_artist'] ?? 0;
    $this->website = $args['website'] ?? '';
    $this->amazon_link = $args['amazon_link'] ?? '';
  }

  // Set info not passed through from input
  public function prepare_for_upload($id)
  {
    $this->created_by = $id;
    self::set_sorted_name();
    self::set_dates();
  }

  // Set and show cleared_by
  public function set_cleared_by($id)
  {
    $this->cleared_by = $id;
  }

  public function show_cleared_by()
  {
    if ($this->cleared_by) {
      $user = User::find_by_id($this->cleared_by);
      //var_dump($user);
      return h($user->username);
    } else {
      return false;
    }
  }

  // If the artist is updated, we have to reset show_artist
  // and cleared_by
  public function reset_show_and_cleared()
  {
    $this->cleared_by = null;
    $this->show_artist = 0;
  }

  // Function to set created_at/updated_at values
  protected function set_dates()
  {
    if (!isset($this->id)) {
      $this->created_at = time();
    } else {
      $this->updated_at = time();
    }
  }

  // Set the name used for sorting the artists
  protected function set_sorted_name()
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

  // Function used for an easy way to show the artist name,
  // no matter if it is a band or a single person
  public function display_name()
  {
    if (!isset($this->lastname)) {
      return h($this->firstname);
    } else {
      return "{$this->firstname} {$this->lastname}";
    }
  }

  // Function to get the user name of the user that "made" the artist 
  public function display_username()
  {
    $user = User::find_by_id($this->created_by);
    if (empty($user)) {
      return 'User deleted';
    } else {
      return h($user->username);
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

  // You need the table name when you upload an image
  // this is a public function that can display that static
  // proteted variable
  public function get_table_name()
  {
    return self::$table_name;
  }
} // class
