<?php echo $this->Flash->render('ConfigManager') ?>
<h1>Configurations</h1>

<?php if(!$config_exists): ?>
  <p>You have not created the config file yet! Make it here:</p>
  <code>[root]/config/config_manager.php</code>
<?php elseif(empty($config)): ?>
  <p>Your configuration file is empty. That's fine if you want it to be.</p>
<?php else: ?>
  <table>
    <?php
      $headers = [
        'Setting',
        'Value',
        'Modified',
        'Actions'
      ];
      echo $this->Html->tableHeaders($headers);

      $cells = [];
      foreach($config as $setting => $value) {

        # Create the list of options
        $actions = $this->Html->link('Edit', ['action' => 'edit', $setting]);

        # Should we show modified or not?
        $nice_modified = (array_key_exists('modified', $value)) ? $value['modified'] : null;
        if(is_null($nice_modified)) {
          $nice_modified = 'Never';
        } else {
          $nice_modified = date('l, F jS, Y \a\t g:i A', $value['modified']);
        }

        # Show the value nicely
        $nice_value = $value['value'];
        $empty = false;

        if(is_null($nice_value) || (is_array($nice_value) && empty($nice_value))) {
          $nice_value = $this->Html->para('italic', 'Empty');
          $empty = true;
        }

        # Special circumstances for different types
        if(array_key_exists('type', $value) && !$empty) {
          # Boolean
          if($value['type'] == 'boolean') {
            $nice_value = ($nice_value) ? 'Yes' : 'No';
          }

          # Array
          if($value['type'] == 'array') {
            $nice_value = $this->Text->toList($nice_value);
          }

          # List
          if($value['type'] == 'list') {
            $nice_value = $this->Text->toList($nice_value);
          }

          # Multiples
          if($value['type'] == 'multi') {
            $list = [];
            foreach($nice_value as $option) {
              $list[] = $value['options'][$option];
            }

            $nice_value = $this->Text->toList($list);
          }

          # Select
          if($value['type'] == 'select') {
            $nice_value = $value['options'][$nice_value];
          }

          # Select
          if($value['type'] == 'radio') {
            $nice_value = $value['options'][$nice_value];
          }

          # File
          if($value['type'] == 'file') {
            $upload_dir = (array_key_exists('upload_dir', $value)) ? $value['upload_dir'] : CONFIG_MANAGER_UPLOAD_DIR;
            $nice_value  = '<div class="file_data">';
            $nice_value .= $this->ConfigManager->file_link($value);
            $nice_value .= $this->Html->tag('span', $value['value']['name'], ['class' => 'file_name']);
            $nice_value .= $this->Html->tag('span', $this->Number->toReadableSize($value['value']['size']), ['class' => 'file_size']);
            $nice_value .= $this->Html->tag('span', $this->ConfigManager->file_type($value['value']['type']), ['class' => 'file_type']);
            $nice_value .= '</div><!-- .file_data -->';
          }
        }

        $cells[] = [
          $setting,
          $nice_value,
          $nice_modified,
          $actions
        ];
      }
      echo $this->Html->tableCells($cells);
    ?>
  </table>
<?php endif ?>