<?php
								$start = microtime(true);





								ini_set('default_charset', 'UTF-8');
								ini_set('mbstring.encoding_translation', 'On');
								mb_internal_encoding("UTF-8");
								mb_http_output("UTF-8");
								mb_regex_encoding("UTF-8");
								header('Content-Type: text/html; charset=utf-8');

								// Set locale to Dutch
								setlocale(LC_ALL, 'ro-RO');

								// Output current date
								// echo utf8_encode(strftime("%A %d %B %Y"));
								// echo iconv("ISO-8859-3", "UTF-8", date("d-m-Y H:i:s"));

/**
 * Front Controller
 *
 * PHP version 7.0.0
 */

/**
 * Twig
 */
require_once dirname(__DIR__) . '/vendor/Twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

/**
 * Autoloader
 */
spl_autoload_register(
	function($class) {
		// Get the parent directory
		$root = dirname(__DIR__);
		$file = $root . '/' . str_replace('\\', '/', $class) . '.php';
		if (is_readable($file)) {
			require $file;
		}
	}
);

/**
 * Error and exception handling
 */
//error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

								// print_r(mb_language());




/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{action}/{id:\d+}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('admin/{controller}/{action}/{id:\d+}', ['namespace' => 'Admin']);

// print_r($router->getRoutes());
// print_r($router->getParams());

/**
 * Dispatch the route
 */
$router->dispatch($_SERVER['QUERY_STRING']);

								//Display the routing table
								// echo '<pre>';
								// var_dump($router->getRoutes());
								// echo htmlspecialchars(print_r($router->getRoutes(), true));
								// echo '</pre>';

								// Match the requested route
								// $url = $_SERVER['REQUEST_URI'];
								// $url = $_SERVER['QUERY_STRING'];
								// echo '<br><br><br>' . $url . '<br><br><br>';

								// if ($router->match($url)) {
								// 	echo '<pre>';
								// 	var_dump($router->getParams());
								// 	echo '</pre>';
								// } else {
								// 	echo 'No route found for URL "', $url, '"';
								// }


								// echo
								//     '<br><br><br><br><br><br>REQUEST_URI -> ' .
								//     $_SERVER['REQUEST_URI'] .
								//     "<br><br><br><br><br><br>";

								//$router->dispatch(ltrim($_SERVER['QUERY_STRING'], '/'));

								// phpinfo(INFO_VARIABLES);

								//echo '<p>Execution time: ', microtime(true) - $start . ' s</p>';