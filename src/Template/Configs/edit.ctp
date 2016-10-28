<h1>Edit "<?php echo $key ?>"</h1>

<?php
  # Define some of this stuff first and easily
  $type = array_key_exists('type', $settings) ? $settings['type'] : 'text';
  $after = null;

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
      case 'date':
        $type = 'text';
        $settings['class'] = 'datepicker';

        # Initialize the datepicker
        $date_format_script = <<<FORMAT
jQuery(document).ready(function() {
  $('.datepicker').datepicker({
FORMAT;
        # If they added a format, allow that here
        $date_format_script .= (array_key_exists('format', $settings)) ? 'dateFormat: "'.$settings['format'].'"' : null;

        # Close it out
        $date_format_script .= <<<FORMAT
  });
});
FORMAT;
        $this->Html->scriptBlock($date_format_script, ['block' => 'script']);
        break;
      case 'datetime':
        # Cool
        break;
      case 'time':
        $settings['timeFormat'] = (array_key_exists('format', $settings)) ? $settings['format'] : null;
        break;
    }
  } else {
    echo $this->Html->para('after', 'We have defaulted to a "text" type since you have not declared a "type" for this configuration setting.');
  }

  echo $this->Form->create();
  echo $this->Form->input('value', $settings);

  if($after) {
    echo $this->Html->para('after', $after);
  }

  echo $this->Form->input('type', ['type' => 'hidden']);
  echo $this->Form->button('Submit');
  echo $this->Form->end();
  echo $this->Html->link('Cancel', ['action' => 'index']);
?>