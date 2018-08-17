<?php

// change to false if you want to Publish
define('DEBUG', true);
// Database Name
define('DB_NAME', 'carrent');
// Database user
define('DB_USER', 'root');
// Database password
define('DB_PASSWORD', '');
// Database Host 
define('DB_HOST', '127.0.0.1');
// Database Driver
define('DB_DRIVER', 'mysql');

// default controller
define('DEFAULT_CONTROLLER', 'Home');
// if no layout set in the controller  
define('DEFAULT_LAYOUT', 'default'); 

// set this to '/' for a live server
define('PROOT', '/ourtime/'); 
// assets folder
define('ASSETS', PROOT.'/assets/'); 
// css folder
define('CSS', ASSETS.'css/'); 
// assets folder
define('JS', ASSETS.'js/'); 
// assets folder
define('VENDOR', ASSETS.'vendor/'); 

// default site tittle
define('SITE_TITLE', 'Car Rental'); 

// session epiry time 30 days 86400 = 1 day
define('REMEMBER_ME_COOKIE_EXPIRY', 2592000); 
// default session name
define('CURRENT_USER_SESSION_NAME', 'kswSADACAJHFAJjsadahafJFjs'); 
// default cookie name remember me
define('REMEMBER_ME_COOKIE_NAME', 'WIADAGAFsa1231hJfJFAnajfj'); 

// controller name restricted redirect
define('ACCESS_RESTRICTED', 'RestrictedController'); 

