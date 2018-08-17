<?php
/**
 *
 */
class Router
{

	public static $acl = null;


	public static function route($url){

		//controller
		$controller_name = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]): DEFAULT_CONTROLLER;
		$controller = $controller_name."Controller";
		array_shift($url);
		//action
		$action = (isset($url[0]) && $url[0] != '') ? $url[0].'Action': 'indexAction';
		$action_name = (isset($url[0]) && $url[0] != '') ? $url[0]: 'indexAction';
		array_shift($url);

		// ACL check
		$grantAccess = self::hasAccess($controller_name, $action_name);
		// dnd($grantAccess);
		if (!$grantAccess) {
			$controller_name = $controller = ACCESS_RESTRICTED;
			$action =  'indexAction';
		}

		//params
		$queryParams = $url;

		if ($controller != 'PDFReceiptController' || $controller != 'PDFReportsController') {
			$dispatch = new $controller($controller, $action_name);
			// dnd($dispatch);
			if(method_exists($controller, $action)) {
				call_user_func_array([$dispatch, $action], $queryParams);
			} else {
				die('Method doenst exixst ! \"'. $controller_name .'\"');
			}
		} else {
			require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . 'PDFController.php');
		}
		
	}

	public static function redirect($location)
	{
		if (!headers_sent()) {
			header('location: '.PROOT.$location);
			exit();
		} else {
			echo "alert('a')";
			echo "<script type='text/javascript'>";
			echo "window.location.href='".PROOT.$location."';";
			echo "</script>";
			echo "<noscript>";
			echo "meta http-equiv='refresh' content='0;url='".$location."'/>";
			echo "</noscript>";exit;
		}
	}

	public static function hasAccess($controller_name, $action_name="index")
	{

		if (!self::$acl) {
			self::$acl = json_decode(file_get_contents(ROOT.DS."app".DS."acl.json"), true);
		}
		$current_user_acls = ["Guest"];
		$grantAccess = false;
		if (Session::exists(CURRENT_USER_SESSION_NAME)) {
			$current_user_acls = ["LoggedIn"];
			foreach (currentUser()->acls() as $a) {
				$current_user_acls[] = $a;
			}
		}

		foreach ($current_user_acls as $level) {

			if (array_key_exists($level, self::$acl) && array_key_exists($controller_name, self::$acl[$level])) {
				if (in_array($action_name, self::$acl[$level][$controller_name]) || in_array("*", self::$acl[$level][$controller_name])) {
					$grantAccess = true;
					break;
				}
			}
		}

		// check for denied
		foreach ($current_user_acls as $level) {
			$denied = self::$acl[$level]['denied'];
			if (!empty($denied) && array_key_exists($controller_name, $denied) && in_array($action_name, $denied[$controller_name])) {
				$grantAccess = false;
				break;
			}
		}
		// var_dump($current_user_acls);
		return $grantAccess;
	}

	public function inclAclFile($value='')
	{
		// code...
	}

	public static function getMenu($menu)
	{
		$menuAry = [];
		$menuFile = file_get_contents(ROOT.DS.'app'.DS.$menu.'.json');
		$acl = json_decode($menuFile, true);
		// dnd($acl);
		foreach ($acl as $key => $val) {
			if (is_array($val)) {
				$sub = [];
				foreach ($val as $k => $v) {
					if ($k == 'separator' && !empty($sub)) {
						$sub[$k] = '';
					} else if ($finalVal = self::get_link($v)) {
						$sub[$k] = $finalVal;
					}
				}
				if (!empty($sub)) {
					$menuAry[$key] = $sub;
				}
			} else {
				if ($finalVal = self::get_link($val)) {
					$menuAry[$key] = $finalVal;
				}
			}
		}
		return $menuAry;
		// dnd($menuAry);
	}

	public static function get_link($val)
	{
		// check if external link (www.krucil.net)
		if (preg_match('/https?:\/\//', $val) == 1) {
			return $val;
		} else {
			$uAry = explode('/', $val);
			$controller_name = ucwords($uAry[0]);
			$action_name = (isset($uAry[1])) ? $uAry[1] : '';
			if (self::hasAccess($controller_name, $action_name)) {
				return PROOT.$val;
			}
			return false;
		}
	}
}
