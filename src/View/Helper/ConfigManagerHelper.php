<?php
namespace ConfigManager\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\View\View;

class ConfigManagerHelper extends Helper {

  public $helpers = ['Html'];

  public function beforeRender() {

    # Define initial scripts
    $js_files = [
      'ConfigManager.config_manager'
    ];

    # Define initial styles
    $css_files = [
      'ConfigManager.config_manager'
    ];

    $need_jquery_ui = false;
    $jquery_ui_types = [
      'date'
    ];

    # Iterate through each of the config settings to see if we need more files
    foreach(Configure::read('ConfigManager') as $setting) {
      if(array_key_exists('type', $setting) && in_array($setting['type'], $jquery_ui_types) && !$need_jquery_ui) {
        $need_jquery_ui = true;
      }
    }

    # We only need this within the ConfigManager plugin
    if($this->request->params['plugin'] == 'ConfigManager') {
      # Only use these on the edit page
      if($need_jquery_ui && $this->request->action == 'edit') {
        $css_files[] = '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css';
        $js_files[] = '//code.jquery.com/ui/1.12.1/jquery-ui.js';
      }

      # Load the JS files automatically
      $this->Html->script(
        $js_files,
        array(
          'block' => 'script'
        )
      );

      # Load the CSS files automatically
      $this->Html->css(
        $css_files,
        array(
          'block' => 'css'
        )
      );
    }
  }
}