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
    $this->file_type = $file[$area]['type']['image'] ?? '';
    $this->tmp_file = $file[$area]['tmp_name']['image'] ?? '';
    $this->upload_error = $file[$area]['error']['image'] ?? '';
    $this->file_size = $file[$area]['size']['image'] ?? '';
  } // __construct

  // Returns the file extension of a file
  protected function get_file_extension($file_name)
  {
    $path_parts = pathinfo($file_name);
    return $file_extension = $path_parts['extension'];
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

  // Set the variables that are used to get info not send with $_FILES
  public function set_max_filesize($mb)
  {
    return $this->max_filesize = calculate_bytes_from_mb($mb);
  }
  public function set_file_path($path)
  {
    return $this->file_path = PUBLIC_PATH . '/assets/images/' . $path;
  }

  // Searches the contents of a file for PHP embeded tag
  // The problem with this check is taht file_get_contents() reads
  // the entire file into memory and then searches it (large file => slow).
  // Using fopen/fread might have better preformance on large files,
  // but the file size we are using, eliminates this problem.
  protected function file_contains_php($file)
  {
    $content = file_get_contents($file);
    $position = strpos($content, '<?php>');
    return $position !== false;
  }

  // If there already are a file with the came name in the directory,
  // add an index to the end of the file name.
  protected function check_file_name_exists($filename)
  {
    $new_filename = '';
    $path = $this->file_path . '/' . $filename;

    if (file_exists($path)) {
      $index = 1;
      $files = scandir($this->file_path);

      do {
        $parts = pathinfo($path);
        $ext = $parts['extension'];
        $part_name = $parts['filename'];
        $new_filename = $part_name . '_' . $index++ . '.' . $ext;
      } while (in_array($new_filename, $files));
      return $new_filename;
    } else {
      return $filename;
    }
  }

  // Validation of the image upload
  protected function validations()
  {
    $errors = array();

    if (!is_uploaded_file($this->tmp_file)) {
      $errors[] = "Does not reference a recently uploaded file";
    } elseif ($this->file_size > $this->max_filesize) {
      $errors[] = "File is to big. Max size " . calculate_mb_from_bytes($this->max_filesize);
    } elseif (!in_array($this->file_type, $this->allowed_mime_types)) {
      $errors[] = "Not an allowed file type.";
    } elseif (!in_array($this->file_extension, $this->allowed_file_extensions)) {
      $errors[] = "Not an allowed file extension";
    } elseif (getimagesize($this->tmp_file) === false) {
      // getimagesize() returns image size details, but more importantly
      // returns false ig the file is not acctually an image file
      $errors[] = "Not a valid image file";
    } elseif (self::file_contains_php($this->tmp_file)) {
      $errors[] = "File contains PHP code";
    }
    return $errors;
  } // validations()

  // Upload the image
  public function upload_image()
  {
    // Check to see if there are any upload errors
    if ($this->upload_error === 0) {
      // Check the validation of the file
      $validation_errors = self::validations();
      if (empty($validation_errors)) {
        // no validation errors
        // check to see if filename is unique, and add index if not
        $file_name = self::check_file_name_exists($this->file_name);
        // set the filepath with the file name
        $file_path = $this->file_path . '/' . $file_name;

        // Upload file
        if (move_uploaded_file($this->tmp_file, $file_path)) {
          return $file_name;
        } else { //(move_uploaded_file)
          return array("Upload of file failed");
        } // else (move_uploaded_file)
      } else { // if (empty($validation_errors))
        return $validation_errors;
      } // else if (empty($validation_errors))
    } else { // if ($this->upload_error === 0)
      return array($this->upload_errors[$this->upload_error]);
    } // else if ($this->upload_error === 0)
  } //upæpad image

  // Delete uploaded image
  public function delete_uploaded_image($dir, $name)
  {
    return unlink(PUBLIC_PATH . '/assets/images/' . $dir . '/' . $name);
  }

  // Get the infprmations that are not send with the file
  public function prepare_upload($max_size, $path)
  {
    $this->set_max_filesize($max_size);
    $this->set_file_path($path);
  }
}// class
