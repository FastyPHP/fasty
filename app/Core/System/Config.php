<?php

namespace App\System;

class Config
{

	private static $data;

	public static function init(){

		Config::$data = require_once ("../config.php");

		date_default_timezone_set(Config::$data['timezone']);
	}

	public static function get($key = false){

		return $key ? Config::$data[$key] : Config::$data;
	}

	public static function set($key, $val){

		return Config::$data[$key] = $val;
	}
}