<?php

namespace Core\Classes;

class ErrorHandler
{

	public function __construct() {

		register_shutdown_function([$this, "check_for_fatal"]);
		set_error_handler([$this, "log_error"]);
		set_exception_handler([$this, "log_exception"]);
		ini_set("display_errors", "off");
		error_reporting(E_ALL);
	}

	function check_for_fatal() {
		$error = error_get_last();
		if($error["type"] == E_ERROR)
			$this->log_error($error["type"], $error["message"], $error["file"], $error["line"]);
	}

	function log_error($num, $str, $file, $line, $context = null) {
		return $this->log_exception(new \ErrorException($str, 0, $num, $file, $line));
	}

	/**
	 * Error reporting
	 * If we're in development mode, show us the errors
	 * Else log them
	 */

	function log_exception($e) {

		if(Config::Get('underdev')){
			echo '<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
			<link rel="stylesheet" href="/Debug/debug.css" >
			<div class="error_debug">
				<h4>Fasty | '. get_class($e) .'</h4>
					
				<div class="body">
					<p><strong>Message:</strong> '. $e->getMessage() .'</p>
					<p><strong>File:</strong> '. $e->getFile() .'</p>
					<p><strong>Line:</strong> '. $e->getLine() .'</p>';

					foreach($e->getTrace() AS $trace) {

						if(isset($trace['type']) && $trace['type'] == '->') $type = '::';
						else $type = '';

						if(isset($trace['class'])) $class = $trace['class'] . $type;
						else $class = '';

						echo '<div class="stack">
							<h5>'. $class .''. $trace['function'] .'</h5>
							<p class="file">'. $trace['file'] .':<span>'. $trace['line'] .'</span></p>
						</div>';
					}

				echo'</div>
			</div>';

		} else {
			logger()->write('site_error', 'Type: '. get_class($e) .' | Message: '. $e->getMessage() .' | File: '. $e->getFile() .' | Line: '. $e->getLine() .' | Stack trace: '. $e->getTraceAsString() .'\r\n');

			redirect('/broken');
		}
		
		exit();
	}
}
?>