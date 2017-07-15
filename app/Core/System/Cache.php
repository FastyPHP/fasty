<?php

/**
 * Cache class
 * @author Champa
 */

namespace App\System;

class Cache
{

	private $cachePath;

	private $cacheExpiration;

	private $cacheExt = '.phpcache';

	public function __construct() {

		$this->cachePath = Config::get('cachePath') .'/';
		$this->cacheExpiration = Config::get('cacheTime');
	}

	public function flush(string $file) : void {

		unlink($this->cachePath . $file . $this->cacheExt);
	}

	public function create(string $file, $value) : ?bool {

		if($this->cacheExpiration > 0) {
			$filecontent = '<?php return '. var_export($value, true) .'; ?>';

			if(file_put_contents($this->cachePath . $file . $this->cacheExt, $filecontent, LOCK_EX))

				return true;
			else

				return false;
		}

		return null;
	}

	public function read(string $file) {

		if(!$this->isValid($this->cachePath . $file . $this->cacheExt))

			return false;
		else

			return require($this->cachePath . $file . $this->cacheExt);
	}

	private function isValid(string $file, bool $delete = false) : bool {

		if(!file_exists($file)) return false;

		$cacheCreation = filemtime($file);

		if(time() > $cacheCreation + $this->cacheExpiration) {

			if($delete) unlink($file);

			return false;
		} else {

			return true;
		}
	}

	public function _cachePath($cachePath = false) {

		if(!$cachePath)
			return $this->cachePath;
		else
			$this->cachePath = $cachePath;
	}

	public function _cacheExpiration($cacheExpiration = false) {

		if(!$cacheExpiration)
			return $this->cacheExpiration;
		else
			$this->cacheExpiration = $cacheExpiration;
	}
}