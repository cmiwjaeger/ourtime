<?php 

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher as Dispatcher;
use Illuminate\Container\Container;

class Database {
 
    function __construct() {
	    $capsule = new Capsule;
	    $capsule->addConnection([
			'driver' => DB_DRIVER,
			'host' => DB_HOST,
			'username' => DB_USER,
			'password' => DB_PASSWORD,
			'database' =>  DB_NAME,
			'charset' => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix' => ''
		]);
	    // Setup the Eloquent ORM… 
		$capsule->setAsGlobal();
		$capsule->bootEloquent();

	}
 
}

new Database;



