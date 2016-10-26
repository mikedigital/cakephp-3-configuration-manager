<?php
use Cake\Routing\Router;

Router::plugin(
  'ConfigManager',
  ['path' => '/config-manager'],
  function ($routes) {
    $routes->fallbacks('DashedRoute');
  }
);
