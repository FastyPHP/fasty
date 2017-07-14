<?php

class WelcomeController
{
	public function sayhi() {
		
		$language = language('welcome');

		view('welcome', [
			'language' => $language
		]);
	}
}
?>
