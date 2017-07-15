<?php

namespace App\System;

class Link
{
	public static $DB, $template, $request, $log, $filesystem, $cache;

	public static function loadObjects(\App\Database\sqlDB $db,
			Template $template,
			\App\Http\Request $requestclass,
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