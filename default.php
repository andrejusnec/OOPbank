<?php
session_start();
define('URL','http://localhost/php_proj/OOPbank/');
define('INSTALL_DIR','/php_proj/OOPbank/');
define('DIR',__DIR__);
define('CSS', 'C:\xampp\htdocs\php_proj\OOPbank\public\css');
//require DIR.'/function.php';
require DIR.'/app/UserCreate.php';
require DIR.'/app/Json.php';
require DIR.'/app/User.php';
//_d($_SESSION, '<----- SESIJA');
?>