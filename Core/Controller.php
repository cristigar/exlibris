<?php
namespace Core;

/**
 * Base controller
 */
abstract class Controller
{
	/**
	 * Parameters from the matched route
	 *
	 * @var array
	 */
	protected $route_params = [];

	/**
	 * Class constructor
	 *
	 * @param array $route_params Parameters from the route
	 *
	 * @return void
	 */
	public function __construct($route_params)
	{
		$this->route_params = $route_params;
	}

	/**
	 * __call magic method
	 *
	 * @param string $name Method to call
	 *
	 * @param array $args Arguments to pass
	 */
	public function __call($name, $args)
	{
		$method = $name . 'Action';

		if (method_exists($this, $method)) {
			if ($this->before() !== false) {
				call_user_func_array([$this, $method], $args);
				$this->after();
			}
		} else {
			// echo "Method $method not found in controller " . get_class($this);
			throw new \Exception(
				"Method $method not found in controller " .
				get_class($this)
			);
			
		}
	}

	/**
	 * Before filter, called before an action method
	 *
	 * @return void
	 */
	protected function before()
	{
	}

	/**
	 * After filter, called after an action method
	 *
	 * @return void
	 */
	protected function after()
	{
	}

	/**
	 * Format a number as singular or plural
	 * 
	 * @param  int    $number       The number to format
	 * @param  string $singularForm The singular form
	 * @param  string $pluralForm   The plural form
	 * 
	 * @return string               Formated number as a string
	 */
	protected function pluralFormat($number, $singularForm, $pluralForm) {
		// Get the absolute value of the number
		$abs = abs($number);

		// Calculate the remainder of division by 100
		$rem = $abs % 100;

		/**
		 * Construct the return string
		 * 
		 * 1st condition: if number = 1 then return '1 carte'
		 * 
		 * 2nd condition: if abs(number) = 0 or the remainder of division
		 * 				  by 100 is situated in between 1...19 then return
		 * 				  '9 cărți'
		 *
		 * else:		  return '23 de cărți'
		 * 
		 * @var [type]
		 */
		if ($number == 1) {
			return $number . ' ' . $singularForm;
		} elseif (($abs >= 0) && ($rem < 20) && ($rem > 0)) {
			return $number . ' ' . $pluralForm;
		} else {
			return $number . ' de ' . $pluralForm;
		}
	}
	
}