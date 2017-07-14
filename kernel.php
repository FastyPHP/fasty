<?php
ob_start();

/**
 * Start our $_SESSION
 */

session_start();

/**
 * Vendor and functions library
 */

require_once ("vendor/autoload.php");
require_once ("core/Libraries/functions.php");

/**
 * Require important stuff
 */

require ("core/Database/database.mysql-pdo.php");
require ("core/Libraries/smarty/libs/Smarty.class.php");
require ("core/Classes/config.class.php");
require ("core/Classes/link.class.php");
require ("core/Classes/error_handler.class.php");
require ("core/Classes/core.class.php");
require ("core/Classes/crypto.class.php");
require ("core/Classes/debug.class.php");
require ("core/Classes/template.class.php");
require ("core/Classes/log.class.php");
require ("core/Classes/router.class.php");
require ("core/Classes/request.class.php");
require ("core/Classes/file.class.php");
require ("core/Classes/cache.class.php");
require ("core/Classes/time.class.php");

/**
 * Register our helpers
 */

require ("core/helpers.php");

/**
 * Namespaces
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Core\Database\MySQL_PDO\Database;
use Core\Classes\Config;
use Core\Classes\Link;
use Core\Classes\ErrorHandler;
use Core\Classes\Debug;
use Core\Classes\Template;
use Core\Classes\Router;
use Core\Classes\Log;
use Core\Classes\Cache;
use Core\Classes\RequestClass;

Debug::executionStart();
Config::Init();

/**
 * Initialize our classes
 */

$router 		=	new Router();

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
	new Database(Config::Get('database')),
	new Template(),
	new RequestClass(),
	new Log(),
	new Filesystem(),
	new Cache(Config::Get('cachePath'), Config::Get('cacheTime'))
);

/**
 * Match a requested url with our array => $router->add
 */

$router->handle($request);

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
		//'ram_usage'		=>	convertBytes(memory_get_usage()),
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
