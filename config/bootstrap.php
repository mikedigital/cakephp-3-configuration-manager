<?php
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;

# Define this once so we never need it again
define('CONFIG_FILENAME', 'config_manager');

Configure::config('default', new PhpConfig());
Configure::load(CONFIG_FILENAME);