<?php
session_start();
define('URL','http://localhost/php_proj/OOPbank/');
define('INSTALL_DIR','/php_proj/OOPbank/');
define('DIR',__DIR__);
//define('API','https://api.exchangeratesapi.io/latest');
//require 'C:\xampp\htdocs\php_proj\OOPbank\app\Currency.php';
define('perm', 'You don\'t have permission to use this function.<br>Try using main page user management');
include 'vendor/autoload.php';
//include DIR.'/exchange.php';
require DIR.'/temp.php';
?>