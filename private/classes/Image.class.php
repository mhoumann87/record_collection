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

  protected $file_extension;
  protected $file_path;

  protected $file_name;
  protected $file_type;
  protected $tmp_file;
  protected $upload_error;
  protected $file_size;

  protected $for_image_upload;

  public function __construct()
  {
    $this->file_name = self::sanitize_file_name($_FILES[$this->for_image_upload]['name']['image'] ?? '');
    $this->file_extension = self::get_file_extension($_FILES[$this->for_image_upload]['name']['image'] ?? '');
    $this->file_type = $_FILES[$this->for_image_upload]['type']['image'] ?? '';
    $this->tmp_file = $_FILES[$this->for_image_upload]['tmp_file']['image'] ?? '';
    $this->upload_error = $_FILES[$this->for_image_upload]['error']['image'] ?? '';
    $this->file_size = $_FILES[$this->for_image_upload]['size']['image'] ?? '';
  }

  // Returns the file extension og a file
  public function get_file_extension($file_name)
  {
    $path_parts = pathinfo($file_name);
    return $file_extension = $path_parts['extension'];
  }

  // Searches the contents of a file for a PHP embed tag
  // The problem with this check is that file_get_contents() reads
  // the entire file into memory and then searched it (large file => slow)
  // Using fopen/fread might have better preformance on larger files,
  // but we are not using large files here, so this is ok.
  protected function file_contains_php($file)
  {
    $contents = file_get_contents($file);
    $position = strpos($contents, '<?php>');
    return $position !== false;
  }

  // Use the function calculate_bytes_from_mb() to set max_filesize
  public function set_max_filesize($mb)
  {
    return $this->max_filesize = calculate_bytes_from_mb($mb);
  }

  // Set the path to save the image
  public function set_file_path($area)
  {
    return $this->file_path = PUBLIC_PATH . '/assets/images/' . $area;
  }

  protected function sanitize_file_name($name)
  {
    // Remove characters that could alter file path.
    // Dissallow spaces, because they causes other headaches.
    // "." is allowed (e.g. "photo.jpg") but ".." is not.
    $name = preg_replace('/([^A-Za-z=-9_\.]|[\.]{2})/', '', $name);
    // basename() ensures a file name and not a path
    $name = basename($name);
    return $name;
  }

  // If there already are a file with the same name in the directory,
  // add an index to the file name
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
    } else {
      return $filename;
    }
  }

  // Validate the image
  protected function validations()
  {
    $errors = array();

    if (!is_uploaded_file($this->tmp_file)) {
      $errors[] = 'Does not reference a recently uploaded file';
    } elseif ($this->file_size > $this->max_filesize) {
      $errors[] = 'File is to big. Max size: ' . calculate_mb_from_bytes($this->max_filesize);
    } elseif (!in_array($this->file_type, $this->allowed_mime_types)) {
      $errors[] = 'Not an allowed file type.';
    } elseif (!in_array($this->file_extension, $this->allowed_file_extensions)) {
      $errors[] = 'Not an allowed file extension';
    } elseif (getimagesize($this->tmp_file) === false) {
      // getimagesize() returns image size details, but more importantly,
      // return false if the file is not acctually an image file.
      $errors[] = 'Not a valid image file';
    } elseif (self::file_contains_php($this->tmp_file)) {
      $errors[] = 'File contains PHP code';
    }
    return $errors;
  }

  // Upload the image
  public function upload_image()
  {
    if ($this->upload_error === 0) {
      $validation_errors = self::validations();

      if (empty($validation_errors)) {
        $file_name = self::check_file_name_exists($this->file_name);
        $file_path = $this->file_path . '/' . $file_name;

        if (move_uploaded_file($this->tmp_file, $file_path)) {
          return $file_name;
        } else {
          return array('Upload of file failed');
        }
      } else {
        return $validation_errors;
      }
    } else {
      return array($this->upload_errors[$this->upload_error]);
    }
  }

  // Delete an uploaded image
  public function delete_uploaded_image($dir, $name)
  {
    return unlink(PUBLIC_PATH . '/assets/images/' . $dir . '/' . $name);
  }

  public function prepare_upload($maxsize, $path, $area)
  {
    $this->for_image_upload = $area;
    $this->set_max_filesize($maxsize);
    $this->set_file_path($path);
    return true;
    // upload the image
  }
}// class
