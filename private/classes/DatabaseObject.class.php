<?php

class DatabaseObject
{
  static protected $db;
  static protected $table_name = '';
  static protected $db_columns = [];
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

  protected function create()
  {
  } //create()


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
  } //find_by_id()

  // * Update
  // ********************

  protected function update()
  {
  } // update()

  // * Delete
  // ********************

  public function delete()
  {
    $sql  = "DELETE FROM " . static::$table_name . " ";
    $sql .= "WHERE id = '" . self::$db->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";

    $result = self::$db->query($sql);
    return $result;
  } // delete()

  /*********************************************
   * "Service" functions for CRUD functions
   **********************************************/

  // Save looks at indut and "decides" if it is an update or create
  public function save()
  {
    // A new record will not have an id yet
    if (isset($this->id)) {
      return $this->update();
    } else {
      return $this->create();
    }
  } // save()

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
  } // instanciate()

  protected function validate()
  {
    $this->errors = [];

    // Add custom validation in the class

    return $this->errors;
  } // validate()

  // Make an array of values from input that are in the db columns
  public function attributes()
  {
    $attributes = [];
    foreach (static::$db_columns as $column) {
      // "Weed" out the columns you don't want here
      if ($column == 'id') {
        continue;
      }
      $attributes[$column] = $this->$column;
    }
    return $attributes;
  } // attributes()

  // Takes the atributes array and makes an new array where the values are sanitized
  protected function sanitized_attributes()
  {
    $sanitized = [];
    foreach ($this->attributes() as $key => $value) {
      $sanitized[$key] = self::$db->escape_string($value);
    }
    return $sanitized;
  } // sanitized_attributes()

  // Function to put in new values form the user on the update page
  public function merge_attributes($args)
  {
    foreach ($args as $key => $value) {
      if (property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  } // merge_attributes()


} // class
