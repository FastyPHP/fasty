<?php

namespace App\Database;

use \PDO;
use App\System\Config;
use App\System\Debug;

class sqlDB
{
	private
		$con,
		$constructQuery,
		$constructParams;

	public function __construct(){
		$this->con = new PDO(
			Config::get('database')['driver'] .':host='. Config::get('database')['host'] .';dbname='. Config::get('database')['database'],
			Config::get('database')['user'],
			Config::get('database')['password'],
			[PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]
		);
	}

	public function beginTransaction() {
		return $this->con->beginTransaction();
	}

	public function commit() {
		return $this->con->commit();
	}

	public function rollBack() {
		return $this->con->rollBack();
	}

	public function destroyConnection() {
		return $this->con = null;
	}

	public function lastID() {
		return $this->con->lastInsertId();
	}

	public function countRows($query) {
		return $query->rowCount();
	}

	public function error() {
		return $this->con->errorCode();
	}

	public function constructQuery(string $query) {
		$this->constructQuery = $query;
	}

	public function constructAddParam(string $key, $val) {
		$this->constructParams[$key] = $val;
	}

	public function fireQuery() {

		return $this->query($this->constructQuery, $this->constructParams);
	}

	public function query(string $query,  ?array$vars = []) {
		$Statement = $this->con->prepare($query);

		if(is_array($vars))
			foreach($vars AS $key => $val){
				if (is_string($val))
					$Statement->bindParam($key, $vars[$key], PDO::PARAM_STR);
				else if(is_integer($val))
					$Statement->bindParam($key, $vars[$key], PDO::PARAM_INT);
			}
		$exec = $Statement->execute();

		if(Config::get('underdev'))
			Debug::addQuery($query, $vars);

		if(!$exec)
			var_dump($Statement->errorInfo());
		else
			return $Statement;
	}

	public function select(string $query, ?array $vars = [], bool $multi = false) {
		$Statement = $this->con->prepare($query);

		if(is_array($vars))
			foreach($vars AS $key => $val){
				if (is_string($val))
					$Statement->bindParam($key, $vars[$key], PDO::PARAM_STR);
				else if(is_integer($val))
					$Statement->bindParam($key, $vars[$key], PDO::PARAM_INT);
			}

		if(!$Statement->execute())
			var_dump($Statement->errorInfo());

		if(Config::get('underdev'))
			Debug::addQuery($query, $vars);

		if(!$multi)
			return $Statement->fetch(PDO::FETCH_ASSOC);
		else
			return $Statement->fetchAll(PDO::FETCH_ASSOC);
	}
}