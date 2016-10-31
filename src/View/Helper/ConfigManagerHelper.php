<?php
namespace ConfigManager\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\View\View;

class ConfigManagerHelper extends Helper {

  public $helpers = ['Html'];

  # Thanks https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/MIME_types#Images_types
  # Text
  # Represents any document that contains text and is theoretically human readable
  public $text_types = [
    'text/plain',
    'text/html',
    'text/css',
    'text/javascript'
  ];

  # Image
  # Represents any kind of images. Videos are not included, though animated images (like animated gif) are describes with an image type.
  public $image_types = [
    'image/gif',
    'image/png',
    'image/jpeg',
    'image/bmp',
    'image/webp'
  ];

  # Audio
  # Represents any kind of audio files
  public $audio_types = [
    'audio/midi',
    'audio/mpeg',
    'audio/webm',
    'audio/ogg',
    'audio/wav'
  ];

  # Video
  # Represents any kind of video files
  public $video_types = [
    'video/webm',
    'video/ogg'
  ];

  # Application
  # Represents any kind of binary data.
  public $application_types = [
    'application/octet-stream',
    'application/pkcs12',
    'application/vnd.mspowerpoint',
    'application/xhtml+xml',
    'application/xml',
    'application/pdf'
  ];

  public function beforeRender() {

    # Define initial scripts
    $js_files = [
      'ConfigManager.config_manager'
    ];

    # Define initial styles
    $css_files = [
      'ConfigManager.config_manager'
    ];

    # We only need this within the ConfigManager plugin
    if($this->request->params['plugin'] == 'ConfigManager') {
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

  public function file_link($setting = array()) {

    $upload_dir = $this->file_upload_dir($setting);

    if($this->is_image($setting['value']['type'])) {
      return $this->Html->image($upload_dir.$setting['value']['name'], ['class' => 'thumbnail']);
    } else {
      return $this->Html->link('View', $upload_dir.$setting['value']['name']);
    }
  }

  public function file_type($file_type = null) {
    if(in_array($file_type, $this->text_types)) {
      return 'Text';
    } elseif(in_array($file_type, $this->image_types)) {
      return 'Image';
    } elseif(in_array($file_type, $this->audio_types)) {
      return 'Audio';
    } elseif(in_array($file_type, $this->video_types)) {
      return 'Video';
    } elseif(in_array($file_type, $this->application_types)) {
      return 'Application';
    } else {
      return 'File';
    }
  }

  public function file_upload_dir($setting = array()) {
    return (array_key_exists('upload_dir', $setting)) ? $setting['upload_dir'] : CONFIG_MANAGER_UPLOAD_DIR;
  }

  public function is_image($file_type = null) {
    return ($this->file_type($file_type) == 'Image') ? true : false;
  }
}