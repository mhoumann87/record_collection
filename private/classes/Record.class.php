<?php

class Record extends DatabaseObject
{
  static protected $table_name = 'records';
  static protected $db_columns = [
    'record_id',
    'user_id',
    'artist_id',
    'title',
    'year',
    'format_id',
    'grade_id',
    'information',
    'image'
  ];
}
