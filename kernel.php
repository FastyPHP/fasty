<?php
ob_start();

/**
 * Start our session
 */

session_start();

/**
 * Vendor
 */

require_once ("vendor/autoload.php");

/**
 * Register our helpers and functions
 */

require ("app/functions.php");
require ("app/helpers.php");

/**
 * Namespaces
 */

use Symfony\Component\{HttpFoundation\Request, Filesystem\Filesystem, Filesystem\Exception\IOExceptionInterface};
use App\Database\sqlDB;
use App\System\{Config, Link, ErrorHandler, Debug, Template, Log, Cache};
use App\Http\{Router, Request AS FastyRequest};

Debug::executionStart();
Config::init();

/**
 * Initialize our classes
 */

$router = new Router();

if(Config::get('error_handler') == 0) {
	$errhandler	= new ErrorHandler();
} else {
	$whoops = new \Whoops\Run;
	$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
	$whoops->register();
}

$request = Request::createFromGlobals();

/**
 * Load all system classes into Link statis vars
 */

Link::loadObjects(
	new sqlDB(),
	new Template(),
	new FastyRequest(),
	new Log(),
	new Filesystem(),
	new Cache()
);

/**
 * Match a requested url with our array => $router->add
 */

echo $router->handle($request);

/**
 * Debug console
 */

if(Config::Get('displayConsole')){
	$end_time = round(microtime(true) - Debug::$execution_start, 4);

	Link::$template->view('System.debug', [
		'queries'		=>	Debug::$sql_queries,
		'templates'		=>	Debug::$templates,
		'languages'		=>	Debug::$languages,
		'execution'		=>	$end_time,
		'peak_ram'		=>	convertBytes(memory_get_peak_usage()),
		'request'		=>	server()
	]);
}

/**
 * Destroy the connection/link with the database
 */

db()->DestroyConnection();

/**
 * Flush all data
 */

ob_flush();
?>