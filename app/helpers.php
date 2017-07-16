<?php

use App\System\Link;

function view(string $template, ?array $params = [], ?int $cacheExpiry = 0) {

	return Link::$template->view($template, $params, $cacheExpiry);
}

function language(string $language) {

	return Link::$template->language($language);
}

function post($key = null, $val = null) {

	return Link::$request->Post($key, $val);
}

function get($key = null, $val = null) {

	return Link::$request->Get($key, $val);
}

function server($key = null, $val = null) {

	return Link::$request->Server($key, $val);
}

function redirect(string $path) {

	return Link::$request->Redirect($path);
}

function showError(int $errorCode) {

	return Link::$request->showError($errorCode);
}

function db() {

	return Link::$DB;
}

function cache() {

	return Link::$cache;
}

function logger() {

	return Link::$log;
}
?>