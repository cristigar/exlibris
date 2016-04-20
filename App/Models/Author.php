<?php
namespace App\Models;

use PDO;

/**
 * Author model
 */
class Author extends \Core\Model
{
	/**
	 * Get all authors and the number of their books as an associative array
	 *
	 * @return array
	 */
	public static function getAll()
	{
		try {

			$db = static::getDb();

			$sql = 
				"SELECT authors.id, authors.name, COUNT(*) AS cnt
				FROM books INNER JOIN authors
					ON books.author = authors.id
				GROUP BY authors.name;";
			
			$stmt = $db->query($sql);

			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results;

		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
	}

	/**
	 * Search for books written by author with id
	 *
	 * @return array
	 */
	public static function by($id)
	{
		try {
			$db = static::getDb();
			$sql = 
				"SELECT
					books.id,
					books.title AS 'title',
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
				WHERE
					books.author = :name
				ORDER BY books.title";
			
			$stmt = $db->prepare($sql);
			$stmt->execute([':name' => $id]);

			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results;

		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
	}
}