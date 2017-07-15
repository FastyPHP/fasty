<?php

namespace App\System;

class Log
{

	public $logPath;

	public function __construct() {

		$this->logPath = Config::Get('logPath');
	}

	public function write(string $logName, string $content) {

		file_put_contents(
			$this->logPath ."/". $logName .".log",
			date('d.m.Y H:i:s') ." | ". $content ."\r\n",
			FILE_APPEND | LOCK_EX
		);
	}

	public function read(string $logName) {

		if($this->exists($logName)){
			$read = fopen($file, "r");
			$data = fread($read, filesize($file) + 1);
			fclose($read);

			return $data;
		} else
			return false;
	}

	public function exists($logName) : bool {
		
		if(file_exists($this->logPath ."/". $logName .'.log')) return true;
		else return false;
	}
}