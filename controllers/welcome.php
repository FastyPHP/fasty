<?php

class Welcome
{
	public function sayhi() {
		
		$language = language('welcome');

		view('welcome', [
			'language' => $language
		]);
	}
}
?>
