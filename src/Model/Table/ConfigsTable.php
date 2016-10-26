<?php
namespace ConfigManager\Model\Table;

use Cake\ORM\Table;

class ConfigsTable extends Table {
  public function formatData($data) {
    $value = $data['value'];

    // Condition-based value formatting
    if($data['type'] == 'list') {
      $value = explode("\n", $value);
      foreach($value as $key => $part) {
        $value[$key] = trim($part);
      }
    }

    return $value;
  }
}