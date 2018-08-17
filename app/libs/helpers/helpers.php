<?php 

function dnd($var) {
	echo "<pre>";
	var_dump($var);
	echo "</pre>";
}

function sanitize($dirty) {
	return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
}

function currentUser() {
	return User::currentLoggedInUser();
}

function posted_values($post) {
	$obj = new stdClass();
	foreach ($post as $key => $val) {
		$obj->$key = sanitize($val);
	}
	return $obj;
}

function currentPage() {
	$currentPage = $_SERVER['REQUEST_URI'];
	if ($currentPage == PROOT || $currentPage == PROOT.'/home/index') {
		$currentPage = PROOT.'home';
	}
	return $currentPage;
}