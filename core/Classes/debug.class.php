<?php

namespace Core\Classes;

class Debug
{
	public static $sql_queries = [], $templates = [], $languages = [], $execution_start = 0;

	public static function addQuery(string $query, ?array $params) : void {
		
		array_push(Debug::$sql_queries, [
			'query'		=>	str_ireplace([
				'SELECT',
				'FROM',
				'WHERE',
				'LIMIT',
				'INNER JOIN',
				'LEFT JOIN',
				'RIGHT JOIN'], [
				'<span>SELECT</span>',
				'<span>FROM</span>',
				'<span>WHERE</span>',
				'<span>LIMIT</span>',
				'<span>INNER JOIN</span>',
				'<span>LEFT JOIN</span>',
				'<span>RIGHT JOIN</span>',], $query),
			'params'	=>	$params
		]);
	}

	public static function addTemplate(string $template, ?array $params) : void {

		array_push(Debug::$templates, [
			'template'		=>	$template,
			'params'		=>	$params
		]);
	}

	public static function addLanguage(string $language) : void {

		array_push(Debug::$languages, $language);
	}

	public static function executionStart() : float {
		return Debug::$execution_start = microtime(true);
	}
}
?>