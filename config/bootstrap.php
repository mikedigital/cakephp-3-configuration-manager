<?php
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;

# Define this once so we never need it again
define('CONFIG_MANAGER_FILENAME', 'config_manager');
define('CONFIG_MANAGER_UPLOAD_DIR', '/uploads/config_manager');

Configure::config('default', new PhpConfig());
Configure::load(CONFIG_MANAGER_FILENAME);