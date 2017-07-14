<?php

namespace Core\Traits;

trait TextParser
{

	/**
	 * Final parsing function
	 * @param $text | string
	 *
	 * @return string
	 */

	function parseText(string $text) : string {

		$text = $this->parseLinks($text);
		$text = $this->parseNewLines($text);

		return $text;
	}

	/**
	 * Converts every \n to <br/>
	 * @param $text | string
	 *
	 * @return string
	 */

	function parseNewLines(string $text) : string {

		return str_replace('\n', '<br/>', $text);
	}

	/**
	 * Converts every link to a html clickable link => <a href="link">link</a>
	 * @param $text | string
	 * @param $protocols | array
	 * @param $attributes | array
	 *
	 * @return string
	 */

	function parseLinks(string $value,
						array $protocols = ['http', 'mail'],
						array $attributes = ['target' => '_blank']) : string {

		$attr = '';
		foreach ($attributes as $key => $val) {
			$attr = ' ' . $key . '="' . htmlentities($val) . '"';
		}
        
		$links = array();

		$value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value);

		foreach ((array)$protocols as $protocol) {
			switch($protocol) {
				case 'http':
				case 'https':   $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { if ($match[1]) $protocol = $match[1]; $link = $match[2] ?: $match[3]; return '<' . array_push($links, "<a $attr href=\"lm/". $protocol .":;:;;:;". str_replace("/", ";:;", $link) ."\">$link</a>") . '>'; }, $value); break;
				case 'mail':    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
				default:        $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { return '<' . array_push($links, "<a $attr href=\"lm/". $protocol .":;:;;:;". str_replace("/", ";:;", $match[1]) ."\">". $match[1]. "</a>") . '>'; }, $value); break;
			}
		}

		return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links){
			return $links[$match[1] - 1];
		}, $value);
	}
}
?>