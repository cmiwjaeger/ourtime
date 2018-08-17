<?php 

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', DIRNAME(__FILE__));
define('CORE', "../".ROOT);


require_once (ROOT.DS."vendor". DS ."autoload.php");
// load config and helpers
require_once(ROOT . DS . 'config' . DS . 'config.php');
require_once(ROOT . DS . 'app' . DS . 'libs' . DS . 'helpers' . DS . 'functions.php');

// load database capsule
require_once(ROOT.DS.'config'.DS.'database.php');

// Auto Load Classes
function autoload($className) {
	if(file_exists(ROOT . DS . 'core' . DS . $className . '.php')) {
		require_once(ROOT . DS . 'core' . DS . $className . '.php');
	} elseif (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php')) {
		require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php');
	} elseif (file_exists(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php')) {
		require_once(ROOT . DS . 'app' . DS . 'models' . DS . $className . '.php');
	}
}

spl_autoload_register('autoload');
session_start();
// load flash messages
require_once(ROOT.DS.'core'.DS.'FlashMessages.php');
$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];

if (!Session::exists(CURRENT_USER_SESSION_NAME) && Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
	User::loginUserFromCookie();
}

// Route the request
Router::route($url);
