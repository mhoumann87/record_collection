<?php

class Wishlist extends DatabaseObject
{

  static protected $table_name = 'wishlists';
  static protected $db_colomns = [
    'id',
    'user_id',
    'record_id',
    'format_id'
  ];
}
