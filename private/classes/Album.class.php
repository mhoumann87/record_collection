<?php

class Album extends DatabaseObject
{
  static protected $table_name = 'albums';
  static protected $db_columns = [
    'id',
    'artist_id',
    'title',
    'year',
    'imformation',
    'image_link',
    'image'
  ];

  public $id;
  public $artist_id;
  public $title;
  public $year;
  public $information;
  public $image_link;
  public $image;

  public function __construct($args = [])
  {
    $this->artist_id = $args['artist_id'] ?? '';
    $this->title = $args['title'] ?? '';
    $this->year = $args['year'] ?? '';
    $this->information = $args['information'] ?? '';
    $this->image_link = $args['image_link'] ?? '';
    $this->image = $args['image'] ?? '';
  }
}// class
