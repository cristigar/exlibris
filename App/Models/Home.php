<?php
namespace App\Models;

use PDO;

/**
 * Home model
 */
class Home extends Core\Model
{
	/**
	 * Get all the records as an associative array
	 *
	 * @return array
	 */
	public static function getAll()
	{
		try {
		
			$db = static::getDb();

			$stmt = $db->query(
				"SELECT
					books.title AS 'book_title',
					authors.name AS 'author',
					books.pub_year AS 'pub_year',
					books.num_of_pages AS 'num_of_pages',
					langs.name AS 'lang',
					publishers.name AS 'publisher',
					localities.name AS 'locality',
					books.isbn
				FROM books
					LEFT JOIN authors ON books.author = authors.id
					LEFT JOIN langs ON books.lang = langs.id
					LEFT JOIN publishers ON books.publisher = publishers.id
					LEFT JOIN localities ON books.locality = localities.id
				ORDER BY books.title"
			);

			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			return $results;

		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
	}
}
