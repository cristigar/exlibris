<?php
namespace Core;

use PDO;
use App\Config;

/**
 * Base model
 */
abstract class Model
{
	protected static $db = null;

	/**
	 * Get the PDO database connection
	 *
	 * @return mixed
	 */
	protected static function getDb()
	{

		// $db = null;
		if (static::$db == null) {
			$db = new PDO(
				'mysql:host=' . Config::DB_HOST .
				';dbname=' 	  . Config::DB_NAME . ';charset=utf8',
								Config::DB_USER,
								Config::DB_PASS
			);

			// Throw an exception when an error occurs
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			return $db;
		}
	}
}