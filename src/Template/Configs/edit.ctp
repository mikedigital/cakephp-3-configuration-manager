<h1>Edit "<?php echo $key ?>"</h1>

<?php
  # Define some of this stuff first and easily
  $type = array_key_exists('type', $settings) ? $settings['type'] : 'text';
  $after = null;

  # Set a default value if none exists
  $settings['value'] = (array_key_exists('value', $settings)) ? $settings['value'] : null;

  # We don't need this here if we've got it
  if(array_key_exists('modified', $settings)) {
    unset($settings['modified']);
  }

  # Special exceptions and other stuff
  if(array_key_exists('type', $settings)) {
    switch($settings['type']) {
      case 'boolean':
        $settings['type'] = 'radio';
        $settings['options'] = [
          0 => 'No',
          1 => 'Yes'
        ];
        break;
      case 'list':
        $settings['type'] = 'textarea';
        $after = 'Separate each entry with a line break.';
        $settings['value'] = implode("\n", $settings['value']);
        break;
      case 'multicheckbox':
        $after = 'Select all that apply.';
        $settings['default'] = $settings['value'];
        break;
      case 'select':
        $settings['default'] = $settings['value'];
        break;
      case 'radio':
        $settings['default'] = $settings['value'];
        break;
    }
  } else {
    echo $this->Html->para('after', 'We have defaulted to a "text" type since you have not declared a "type" for this configuration setting.');
  }

  echo $this->Form->create(null, ['type' => 'file']); // We default to file just in case. It can't hurt.
  echo $this->Html->para('before', 'Expecting '.$settings['type']);


  if($settings['type'] == 'file') {
    echo $this->Form->input('upload_dir', ['value' => $this->ConfigManager->file_upload_dir($settings), 'type' => 'hidden']);

    if($settings['value']) {
      echo $this->Html->para(null, 'Current File');
      echo $this->ConfigManager->file_link($settings);
      echo $this->Form->input('remove_current_file', ['type' => 'checkbox', 'value' => $settings['value']['name']]);
    }

    # We don't want this added to the list of setting parameters
    unset($settings['upload_dir']);
  }

  echo $this->Form->input('value', $settings);
  echo $this->Form->input('setting_name', ['type' => 'hidden', 'value' => $key]);

  if($after) {
    echo $this->Html->para('after', $after);
  }

  echo $this->Form->input('type', ['type' => 'hidden']);
  echo $this->Form->button('Submit');
  echo $this->Form->end();
  echo $this->Html->link('Cancel', ['action' => 'index']);
?>