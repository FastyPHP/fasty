<?php

namespace Core\Classes;

class Config
{

	private static $data;

	public static function Init(){

		Config::$data = require_once ("../config.php");

		date_default_timezone_set(Config::$data['timezone']);
	}

	public static function Get($key = false){

		return $key ? Config::$data[$key] : Config::$data;
	}

	public static function Set($key, $val){

		return Config::$data[$key] = $val;
	}
}
?>