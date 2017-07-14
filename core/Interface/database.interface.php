<?php

namespace Core\Interfaces;

use PDOStatement;

/**
 * The database interface
 */

interface Database
{
	public function beginTransaction();
	public function commit();
	public function rollBack();
	public function DestroyConnection();
	public function LastID();
	public function CountRows($query);
	public function Error();
	public function ConstructQuery(string $query);
	public function ConstructAddParam(string $key, $val);
	public function FireQuery();
	public function Query(string $query, ?array $vars = []);
	public function Select(string $query, ?array $vars = [], bool $multi = false);
}

?>
