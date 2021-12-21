<?php
// Load Config
require_once 'config/config.php';
// Load Helpers
require_once 'helpers/functions.php';
require_once 'helpers/sessionHelper.php';
require_once 'helpers/urlHelper.php';
require_once 'helpers/global.php';

// Autoload Core Libraries
spl_autoload_register(function ($className) {
  require_once 'libraries/' . $className . '.php';
});
