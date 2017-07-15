<?php

namespace App\Http;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel;
use App\System\Core;

class Router extends Core
{
	/**
	 * @param RouteCollection
	 */

	protected $routes;

	/**
	 * Creates a new router collection
	 *
	 * @return void
	 */

	public function __construct() {

		$this->routes = new RouteCollection();
	}

	/**
	 * Tries to match a given URI to a route
	 *
	 * @param $request | Request
	 *
	 * @return mixed
	 */

	public function handle($request){

		$context = new RequestContext();
		$context->fromRequest($request);
		$response = true;

		if($context->getMethod() == 'GET')
			require ('../routes/GetRoutes.php');
		else
			require ('../routes/PostRoutes.php');

		$matcher = new UrlMatcher($this->routes, $context);

		try {
			$attributes = $matcher->match($request->getPathInfo());
			$controller = $attributes['controller'];

			if(is_string($controller) && $this->validMethodController($controller)) {

				$controller = $this->createActionFromController($controller);

				if(!class_exists($controller[0]))
					require ('../controllers/'. $controller[0] .'.php');

				$conobj = new $controller[0]();

				if(is_callable(array($conobj, $controller[1])))
					$response = call_user_func_array(array($conobj, $controller[1]), $this->prepareArgsForMethod($attributes));

			} else if(parent::isClosure($controller))
				$response = call_user_func_array($controller, $this->prepareArgsForMethod($attributes));
			else if(is_callable($controller))
				call_user_func_array($controller, $this->prepareArgsForMethod($attributes));

		} catch (ResourceNotFoundException $e) {
			$response = $e;
		}

		return $response;
	}

	/**
	 * Add a POST route
	 *
	 * @param $path | string
	 * @param $controller | string|closure
	 *
	 * @return void
	 */

	public function post($path, $controller) : void {

		$this->add($path, $controller, 'POST');
	}

	/**
	 * Add a GET route
	 *
	 * @param $path | string
	 * @param $controller | string|closure
	 *
	 * @return void
	 */

	public function get($path, $controller) : void {

		$this->add($path, $controller, 'GET');
	}

	/**
	 * Add a path and a controller to the route
	 *
	 * @param $path | string
	 * @param $controller | string|closure
	 * @param $method | string
	 *
	 * @return void
	 */

	private function add(string $path, $controller, string $method) : void {
		$this->routes->add($path, new Route(
			$path,
			array('controller' => $controller),
			[],
			[],
			'',
			[],
			[$method]
		));
	}

	/**
	 * Checks if a given string is a valid controller string Class@Method
	 *
	 * @param $action | string
	 *
	 * @return bool
	 */

	private function validMethodController(string $action) : bool {

		if(strpos($action, '@') !== false)
			return true;
		else
			return false;
	}

	/**
	 * Prepares args for call_user_func_array()
	 *
	 * @param $array | array
	 *
	 * @return array
	 */

	private function prepareArgsForMethod(array $array) : array {

		unset($array['controller'], $array['_route']);
		
		return $array;
	}

	/**
	 * Cuts the string on every @
	 *
	 * @param $action | string
	 *
	 * @return array
	 */

	private function createActionFromController(string $action) : array {

		return explode("@", $action);
	}
}
?>
