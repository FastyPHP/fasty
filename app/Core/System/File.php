<?php

namespace App\System;

class File
{
	private $fileName;

	private $fileSize;

	private $filePath;

	private $fileContent;
	
	private $fullPath;

	public function __construct(string $path, string $name){

		$this->filePath = $path;
		$this->fileName = $name;
		$this->fullPath = $this->filePath .'/'. $this->fileName;

		$this->open();
	}

	private function open(){
		if(file_exists($this->fullPath)){

			$this->fileSize = filesize($this->fullPath);
			$this->fileContent = file_get_contents($this->fullPath);
		} else
			$this->fileContent = false;
	}

	public function size(){
		return $this->fileSize;
	}

	public function path(){
		return $this->filePath;
	}

	public function content(){
		return $this->fileContent;
	}

	public function name(){
		return $this->fileName;
	}

	public function fullPath(){
		return $this->fullPath;
	}
}