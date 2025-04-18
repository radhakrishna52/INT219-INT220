<?php
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'virtual_exhibition');

// Site configuration
define('SITE_URL', 'http://localhost/virtual-exhibition');
define('UPLOAD_DIR', 'uploads/');

// Include other required files
require_once 'db.php';
require_once 'functions.php';
require_once 'auth.php';
?>