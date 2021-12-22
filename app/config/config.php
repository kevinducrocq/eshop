<?php
ob_start();
session_start();

// DB Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'eshop');

// App Root 
define('APPROOT', dirname(dirname(__FILE__)));
define('VENDORROOT', '../vendor/');
define('APISTRIPE', 'sk_test_51Jk8oDCetpwHurzPmOoSU63hSiLKBl4vy8XxuwgHCICRVOqBlEQMr1JegxM6DRU8MgT02rzgZPoFM1EiHqUYoiJx00E148tMcy');
// URL Root
define('URLROOT', 'http://localhost/eshop');
// Site Name
define('SITENAME', 'Eshop');
