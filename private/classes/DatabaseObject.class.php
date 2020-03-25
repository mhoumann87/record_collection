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
    // Check to see if the input is valid
    $this->validate();
    if (!empty($this->errors)) {
      return false;
    }

    // Clean the input
    $attributes = $this->sanitized_attributes();

    // Insert the input in the database
    $sql  = "INSERT INTO " . static::$table_name . " (";
    $sql .= join(', ', array_keys($attributes));
    $sql .= ") VALUES ('";
    $sql .= join("', '", array_values($attributes));
    $sql .= "')";
    //return $sql;

    $result = self::$db->query($sql);

    // Get the id from the database and add it to the object
    if ($result) {
      $this->id  = self::$db->insert_id;
    }
    return $result;
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

  static public function find_all_and_sort($sort_by)
  {
    $sql  = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "ORDER BY " . self::$db->escape_string($sort_by) . " ASC";

    return static::find_by_sql($sql);
  } // find_all_and_sort()

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

  // Find by field and sort result
  static public function find_by_field_and_sort($field, $value, $sort)
  {
    $sql  = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE " . self::$db->escape_string($field) . "='";
    $sql .= self::$db->escape_string($value) . "' ";
    $sql .= "ORDER BY " . self::$db->escape_string($sort) . " ASC";

    return static::find_by_sql($sql);
  }

  // * Update
  // ********************

  protected function update()
  {
    // Check to see if input is valid
    $this->validate();
    if (!empty($this->errors)) {
      return false;
    }

    // Clear the input
    $attributes = $this->sanitized_attributes();

    // Make an array for the input
    $attribute_pairs = [];
    foreach ($attributes as $key => $value) {
      $attribute_pairs[] = "{$key}='{$value}'";
    }

    // Upload to the database
    $sql  = "UPDATE " . static::$table_name . " SET ";
    $sql .= join(', ', $attribute_pairs);
    $sql .= " WHERE id='" . self::$db->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";
    // echo $sql;
    $result = self::$db->query($sql);
    return $result;
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
