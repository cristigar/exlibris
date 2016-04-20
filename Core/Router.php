<?php
namespace Core;

/**
 * Router
 */
class Router
{

	/**
	 * Associative array of routes (the routing table)
	 * @var array
	 */
	private $routes = [];

	/**
	 * Parameters from the matched route
	 * @var array
	 */
	private $params = [];


	/**
	 * Add a route to the routing table
	 *
	 * @param string    $route    The route URI
	 * @param array     $params   Parameters (controller, action, etc.)
	 *
	 * @return void
	 */
	public function add($route, $params = [])
	{
		// Convert the route to a regular expression: escape forward slashes
		$route = preg_replace('/\//', '\\/', $route);

		// Convert variables (ex. {controller})
		$route = preg_replace('/\{([a-z]+)\}/', '(?<$1>[a-z-]+)', $route);

		// Convert variables with custom regular expressions (ex. {id: \d+})
		$route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?<$1>$2)', $route);

		// Add start and end delimiters and case-insensitive flag
		$route = '/^' . $route . '$/i';

		$this->routes[$route] = $params;
	}

	/**
	 * Get all the routes from the routing table
	 *
	 * @return array
	 */
	public function getRoutes()
	{
		return $this->routes;
	}

	/**
	 * Match the route to the routes in the routing table, setting the $params
	 * property if a route is found.
	 * 
	 * @param   string   $url   The route URL
	 *
	 * @return  boolean  true   if a match found,
	 *                   false  otherwise
	 */
	public function match($url)
	{
		foreach ($this->routes as $route => $params) {
			if (preg_match($route, $url, $matches)) {
				// Get named capture group values
				foreach ($matches as $key => $match) {
					if (is_string($key)) {
						$params[$key] = $match;
					}
				}

				$this->params = $params;
				return true;
			}
		}

		

		return false;
	}

	/**
	 * Get the currently matched parameters
	 *
	 * @return array
	 */
	public function getParams()
	{
		return $this->params;
	}

	/**
	 * Dispatch the route, creating the controller object and running the action method
	 * 
	 * @param string $url The $route URL
	 * 
	 * @return void
	 */
	public function dispatch($url)
	{
		$url = $this->removeQueryStringVariables($url);

		if ($this->match($url)) {
			$controller = $this->params['controller'];
			$controller = $this->convertToStudlyCaps($controller);
			$controller = $this->getNamespace() . $controller;

			if (class_exists($controller)) {
				$controller_object = new $controller($this->params);

				$action = $this->params['action'];
				$action = $this->convertToCamelCase($action);

				if (is_callable([$controller_object, $action])) {
					
					if (isset($this->params['id']) AND is_numeric($this->params['id'])) {
						$controller_object->$action($this->params['id']);
					} else {
						$controller_object->$action();
					}

				} else {
					//echo "Method $action in controller $controller not found";
					throw new \Exception(
						"Method $action (in controller $controller) not found"
					);
				}
			} else {
				//echo 'Controller class ' . $controller . ' not found';
				throw new \Exception(
					"Controller class $controller not found"
				);
			}
		} else {
			// echo 'No route matched';
			throw new \Exception('No route matched.', 404);
		}
	}

	/**
	 * Convert the string with hyphens to StudlyCaps
	 * ex. post-authors => PostAuthors
	 *
	 * @param   string  $string  The string to convert
	 *
	 * @return  string
	 */
	private function convertToStudlyCaps($string)
	{
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
	}

	/**
	 * Convert the string with hyphens to camelCase
	 * ex. add-new => addNew
	 *
	 * @param   string  $string  The string to convert
	 *
	 * @return  string
	 */
	private function convertToCamelCase($string)
	{
		return lcfirst($this->convertToStudlyCaps($string));
	}

	/**
	 * Remove the query string variables form the URL (if any). As the full query
	 * string is used for the route, any variables at the end will need to be
	 * removed before the route is matched to the routing table.
	 * 
	 * @param string $utl The full URL
	 * 
	 * @return string The URL with the query variables removed
	 */
	private function removeQueryStringVariables($url)
	{
		if ($url != '') {
			$parts = explode('&', $url);
			
			if (strpos($parts[0], '=') === false) {
				$url = $parts[0];
			} else {
				$url = '';
			}
		}
		return $url;
	}

	/**
	 * Get the namespace for the controller class. The namespace defined in the
	 * route parameters is added if present.
	 *
	 * @return  string The request URL
	 */
	protected function getNamespace()
	{
		$namespace = 'App\Controllers\\';

		if (array_key_exists('namespace', $this->params)) {
			$namespace .= $this->params['namespace'] . '\\';
		}

		return $namespace;
	}

}





