<?php

class Image
{

  // Set the path to the destinations folder for the image
  protected $upload_path;
  // Define allowed filetypes to check against during validation
  protected $allowed_mime_types = [
    'image/png',
    'image/gif',
    'image/jpg',
    'image/jpeg'
  ];

  protected $allowed_file_extensions = [
    'png',
    'gif',
    'jpg',
    'jpeg'
  ];

  protected $upload_errors = [
    UPLOAD_ERR_OK         => "No errors.",
    UPLOAD_ERR_INI_SIZE   => "Larger that upload max_filesize.",
    UPLOAD_ERR_FORM_SIZE  => "Larger than form MAX_FILE_SIZE.",
    UPLOAD_ERR_PARTIAL    => "Partial upload.",
    UPLOAD_ERR_NO_FILE    => "No File.",
    UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
    UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
    UPLOAD_ERR_EXTENSION  => "File upload stopped by extension."
  ];

  // Set your own max file size based on variable in the main class
  protected $max_filesize;
  // Set filepath based on $table_names
  protected $file_path;

  protected $file_extension;
  protected $file_name;
  protected $file_type;
  protected $tmp_file;
  protected $upload_error;
  protected $file_size;





  public function __construct($file, $area)
  {
    $this->file_name = self::sanitize_file_name($file[$area]['name']['image'] ?? '');
    $this->file_extension = self::get_file_extension($file[$area]['name']['image'] ?? '');
  } // __construct

  // Returns the file extension of a file
  protected function get_file_extension($file_name)
  {
    $path_parts = pathinfo($file_name);
    return $file_extension = $path_parts['extension'];
  }

  // Set the variables that are used to get info not send with $_FILES
  public function set_max_filesize($mb)
  {
    return $this->max_filesize = calculate_bytes_from_mb($mb);
  }
  public function set_file_path($path)
  {
    return $this->file_path = PUBLIC_PATH . '/assets/images/' . $path;
  }

  // Remove characters that could alter file path.
  // Dissallow spaces, because they causes other headaches.
  // "." is allowed (e.g. "photo.jpg"), but ".." is not.
  protected function sanitize_file_name($name)
  {
    $name = preg_replace('/([^A-Za-z0-9_\.]|[\.]{2})/', '', $name);
    // basename() ensures a filename and not a path
    $name = basename($name);
    return $name;
  }


  // Get the infprmations that are not send with the file
  public function prepare_upload($max_size, $path)
  {
    $this->set_max_filesize($max_size);
    $this->set_file_path($path);
  }
}// class
