<?php
namespace ConfigManager\Model\Table;

use Cake\ORM\Table;

class ConfigsTable extends Table {
  public function formatData($data) {
    $value = $data['value'];

    // Condition-based value formatting
    # List
    if($data['type'] == 'list') {
      $value = explode("\n", $value);
      foreach($value as $key => $part) {
        $value[$key] = trim($part);
      }
    }

    # File
    if($data['type'] == 'file') {
      # Predefine some variables
      $upload_dir = WWW_ROOT.$data['upload_dir'];
      $remove_current_file = (array_key_exists('remove_current_file', $data) && $data['remove_current_file']) ? true : false;

      # If they want to remove the current file, let's do that now
      if($remove_current_file) {
        # Check if the file exists
        $old_file = $upload_dir.basename($data['remove_current_file']);

        # If the file exists, delete it
        if(file_exists($old_file)) {
          unlink($old_file);
        }
      }

      # Upload the file
      if(is_array($value) && $value['error'] == UPLOAD_ERR_OK) {
        # Inspired by http://www.php.net/manual/en/features.file-upload.post-method.php
        $uploaded_file_name = $data['setting_name'].'_'.basename($data['value']['name']);
        $upload_file = $upload_dir.$uploaded_file_name;

        # Check to see if the upload dir has been created. If not, create it.
        if(!is_dir($upload_dir)) {
          if(!mkdir($upload_dir, 0755, true)) {
            die('Failed to create folders for "'.$upload_dir.'"');
          }
        }

        if(move_uploaded_file($data['value']['tmp_name'], $upload_file)) {
          // $this->Flash->success('File is valid, and was successfully uploaded.', ['key' => 'ConfigManager']);
        } else {
          die('Failed to upload file "'.$upload_file.'"');
          // $this->Flash->success('Possible file upload attack!', ['key' => 'ConfigManager']);
        }

        # Remove some stuff we don't need
        unset($value['tmp_name']);
        unset($value['error']);
      }

      # If they submitted a type "file" but didn't upload anything, return null
      if($data['value']['error'] == UPLOAD_ERR_NO_FILE && $remove_current_file) {
        $value = null;
      }
    }

    return $value;
  }
}