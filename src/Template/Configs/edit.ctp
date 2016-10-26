<h1>Edit "<?php echo $key ?>"</h1>

<?php
  # Define some of this stuff first and easily
  $type = 'text';
  $after = null;
  $value = $setting['value'];
  $options = null;
  $extras = [];
  // $value =

  if(array_key_exists('type', $setting)) {
    switch($setting['type']) {
      case 'boolean':
        $type = 'radio';
        $options = [
          0 => 'No',
          1 => 'Yes'
        ];
        break;
      case 'list':
        $type = 'textarea';
        $after = 'Separate each entry with a line break.';
        $value = implode("\n", $value);
        break;
      case 'multi':
        $type = 'multicheckbox';
        $after = 'Select all that apply.';
        $options = $setting['options'];
        $extras['default'] = $value;
        break;
      case 'select':
        $type = 'select';
        $options = $setting['options'];
        $extras['default'] = $value;
        break;
    }
  } else {
    echo $this->Html->para(null, 'We have defaulted to a "text" type since you have not declared a "type" for this configuration setting.');
  }

  echo $this->Form->create();
  echo $this->Form->input(
    'value',
    [
      'value' => $value,
      'type' => $type,
      'options' => $options,
      $extras
    ]
  );

  if($after) {
    echo $this->Html->para('after', $after);
  }

  echo $this->Form->input('type', ['type' => 'hidden']);
  echo $this->Form->button('Submit');
  echo $this->Form->end();
  echo $this->Html->link('Cancel', ['action' => 'index']);
?>