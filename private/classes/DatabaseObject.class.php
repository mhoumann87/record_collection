<?php

class DatabaseObject
{
  static protected $db;
  static protected $table_name = '';
  static protected $columns = [];
  public $errors = [];

  static public function set_database($db)
  {
    self::$db = $db;
  }

  /*****************************************
   * CRUD operations
   ******************************************/

  // * Create
  // ********************


  // * Read
  // ********************

  static public function find_by_sql($sql)
  {
    $result = self::$db->query($sql);
    if (!$result) {
      exit("Database query failed");
    }
    $object_array = [];
    // Convert the result into an object
    while ($record = $result->fetch_assoc()) {
      $object_array[] = static::instanciate($record);
    }
    $result->free();
    return $object_array;
  } // find_by_sql()

  static public function find_all()
  {

    $sql = "SELECT * FROM " . static::$table_name;
    return static::find_by_sql($sql);
  } // find_all()

  static public function find_by_id($id)
  {
    $sql  = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE id = '" . self::$db->escape_string($id) . "'";

    $object_array = static::find_by_sql($sql);

    if (!empty($object_array)) {
      return array_shift($object_array);
    } else {
      return false;
    }
  }

  // * Update
  // ********************

  // * Delete
  // ********************




  /*********************************************
   * "Service" functions for CRUD functions
   **********************************************/

  // Instanciate connects the values to the columns in the database
  static protected function instanciate($record)
  {
    $object = new static;

    foreach ($record as $property => $value) {
      if (property_exists($object, $property)) {
        $object->$property = $value;
      }
    }
    return $object;
  }
} // class
