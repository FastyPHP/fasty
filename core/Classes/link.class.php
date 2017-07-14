<?php

namespace Core\Classes;

class Link
{
	public static $DB, $template, $request, $log, $filesystem, $cache;

	public static function loadObjects(\Core\Database\MySQL_PDO\Database $db,
			Template $template,
			RequestClass $requestclass,
			Log $log,
			\Symfony\Component\Filesystem\Filesystem $filesystem,
			Cache $cache){

		Link::$DB = $db;
		Link::$template = $template;
		Link::$request = $requestclass;
		Link::$log = $log;
		Link::$filesystem = $filesystem;
		Link::$cache = $cache;
	}
}
?>