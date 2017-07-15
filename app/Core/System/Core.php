<?php

namespace App\System;

class Core
{

	/**
	 * Check if the param is a closure
	 * @param $closure | mixed
	 *
	 * @return bool
	 */

	public static function isClosure($closure) : bool {

		$reflection = new \ReflectionFunction($closure);

		return (bool) $reflection->isClosure();
	}

	/**
	 * Check if an extension is loaded
	 * @param $name | string
	 *
	 * @return bool
	 */

	public static function isExtLoaded(string $name) : bool {

		return extension_loaded($name);
	}

	/**
	 * Hashes a string and returns an array containing the source string, hashed string and the salt
	 * @param $string | string - Rijec/string koju hashujemo (kriptujemo)
	 *
	 * @return array [hashed, salt, source]
	 */

	public static function passwordHash(string $string) : array {

		$hash['salt'] = hash('sha256', time() - 10000);
		$hash['hashed'] = hash('md5', $hash['salt'] . $string);
		$hash['source'] = $string;

		return $hash;
	}

	/**
	 * Compares two hashes
	 * @param $salt | string
	 * @param $string | string
	 * @param $source | string
	 *
	 * @return bool
	 */

	public static function compareHash(string $salt, string $string, string $source) : bool {

		$compare = hash('md5', $salt.$string);

		if($compare == $source) return true;
		else return false;
	}
	
	/**
	 * Checks if the given email is valid
	 * @param $email | string
	 * 
	 * @return bool
	 */

	public static function validEmail($email){

		if(strpos($email, '@') === false || strpos($email, '.') === false) return false;
		else return true;
	}
	
	/**
	 * Checks if the given params are a valid firstname lastname
	 * 
	 * @param $firstname | string
	 * @param $lastname | string
	 *
	 * @return bool
	 */

	public static function validName($firstname, $lastname){

		if(!preg_match("/^[a-zA-ZčšžđćČŠŽĐĆ'-]+$/", ''. $firstname .''. $lastname .'')) return false;
		else return true;
	}
}