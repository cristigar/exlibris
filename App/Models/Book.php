<?php
namespace App\Models;

use PDO;

/**
 * Book model
 */
class Book extends \Core\Model
{
	/**
	 * Get all books as an associative array
	 *
	 * @return array
	 */
	public static function getAll()
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
				ORDER BY books.id DESC";
			
			$stmt = $db->query($sql);

			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results;

		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
	}


	/**
	 * Search for books
	 *
	 * @param mixed $query Query to search (string in case of accuracy = 1,
	 * array in case of accuracy = 0)
	 * @param boolean $accuracy Search accuracy, 1 - search for full word only,
	 * 0 - search using all symbols and REGEXP
	 * 
	 * @return array
	 */
	public static function search($query, $accuracy = 0)
	{
		try {

			$db = static::getDb();

			$sql = 
				"SELECT
					books.id AS id,
					books.title AS title,
					authors.name AS author,
					books.pub_year AS pub_year,
					books.num_of_pages AS num_of_pages,
					langs.name AS lang,
					publishers.name AS publisher,
					localities.name AS locality,
					books.isbn
				FROM books
					LEFT JOIN authors 	 ON books.author 	= authors.id
					LEFT JOIN langs 	 ON books.lang 		= langs.id
					LEFT JOIN publishers ON books.publisher = publishers.id
					LEFT JOIN localities ON books.locality 	= localities.id";

				if ($accuracy) {
					$sql .=
					" WHERE
						LOWER(books.title) 		  LIKE '%$query%'
						OR LOWER(authors.name) 	  LIKE '%$query%'
						OR books.pub_year 		  LIKE '%$query%'
						OR books.num_of_pages 	  LIKE '%$query%'
						OR LOWER(langs.name) 	  LIKE '%$query%'
						OR LOWER(publishers.name) LIKE '%$query%'
						OR LOWER(localities.name) LIKE '%$query%'
						OR books.isbn 			  LIKE '%$query%'
					ORDER BY books.id DESC";
				} else {
					$sql .=
					"\nWHERE LOWER(title) REGEXP '.*";
					foreach ($query as $symbol) $sql .= $symbol . '.*';
					$sql .= "' \nOR LOWER(authors.name) REGEXP '.*";
					foreach ($query as $symbol) $sql .= $symbol . '.*';
					$sql .= "' \nOR pub_year REGEXP '.*";
					foreach ($query as $symbol) $sql .= $symbol . '.*';
					$sql .= "' \nOR num_of_pages REGEXP '.*";
					foreach ($query as $symbol) $sql .= $symbol . '.*';
					$sql .= "' \nOR LOWER(langs.name) REGEXP '.*";
					foreach ($query as $symbol) $sql .= $symbol . '.*';
					$sql .= "' \nOR LOWER(publishers.name) REGEXP '.*";
					foreach ($query as $symbol) $sql .= $symbol . '.*';
					$sql .= "' \nOR LOWER(localities.name) REGEXP '.*";
					foreach ($query as $symbol) $sql .= $symbol . '.*';
					$sql .= "' \nOR LOWER(isbn) REGEXP '.*";
					foreach ($query as $symbol) $sql .= $symbol . '.*';
					$sql .= "' \nORDER BY books.id DESC";

				}
							
			$stmt = $db->query($sql);

			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results;

		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
	}


	/**
	 * Get all distinct objects (authors, langs, localities, publishers) from a table
	 *
	 * @param string $table the table to select
	 * @return array
	 */
	public static function getTables()
	{
		try {

			$db = static::getDb();
			
			$stmt = $db->query("SELECT DISTINCT authors.id, name FROM authors ORDER BY name ASC");
			$authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$stmt = $db->query("SELECT DISTINCT langs.id, name FROM langs ORDER BY name ASC");
			$langs = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$stmt = $db->query("SELECT DISTINCT localities.id, name FROM localities ORDER BY name ASC");
			$localities = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$stmt = $db->query("SELECT DISTINCT publishers.id, name FROM publishers ORDER BY name ASC");
			$publishers = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$results = [];

			/**
			 * Post-fetch the results to look like
			 *
			 * $results = [
			 *   'authors' => [
			 *       '12' => 'Smith John',
			 *       ...
			 *   ],
			 *   'langs' => [
			 *       '37' => 'Lingua Franca',
			 *       ...
			 *   ],
			 *   ...
			 * ];
			 * 
			 */
			foreach ($authors as $k => $author)
				$results['authors'][$author['id']] = $author['name'];
			foreach ($langs as $k => $lang)
				$results['langs'][$lang['id']] = $lang['name'];
			foreach ($localities as $k => $localities)
				$results['localities'][$localities['id']] = $localities['name'];
			foreach ($publishers as $k => $publisher)
				$results['publishers'][$publisher['id']] = $publisher['name'];

			return $results;

		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
	}


	/**
	 * Check if a specific record is present in a table
	 *
	 * @param    string    $value The value to look for
	 * @param    string    $table The table to look in
	 *
	 * @return   boolean   Return true if the record is found, false - otherwise
	 */
	public static function checkPresence($value, $table)
	{
		try {
			
			$db = static::getDb();
			$sql = 
				"SELECT id, name FROM $table
				WHERE name = :value
				LIMIT 1";
			
			$stmt = $db->prepare($sql);
			$stmt->execute([':value' => $value]);

			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			return $results;

		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
		
	}

	/**
	 * Insert a new record into an existing table
	 *
	 * @param    string    $value    The value to insert
	 * @param    string    $table    The table to insert into
	 *
	 * @return   int       ID of the inserted record
	 */
	public static function insertNew($value, $table)
	{
		try {

			$db = static::getDb();
			$sql = 
				"INSERT INTO $table(name)
				VALUES (:value)";
			
			$stmt = $db->prepare($sql);
			$stmt->execute([':value' => $value]);
			
			return $db->lastInsertId('id');

		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
		
	}


	/**
	 * Insert a new book
	 * 
	 * @param string  $title        Title of the book
	 * @param int     $authorId     Author of the book
	 * @param int     $pubYear      Year of publishing
	 * @param int     $numOfPages   Number of pages
	 * @param int     $langId       Language of the book
	 * @param int     $publisherId  Publisher of the book
	 * @param int     $localityId   Locality in which the book was published
	 * @param string  $isbn         ISBN of the book
	 *
	 * @return void
	 */
	public static function add(
		$title, $authorId, $pubYear, $numOfPages,
		$langId, $publisherId, $localityId, $isbn)
	{
		try {

			$db = static::getDb();
			$sql = 
				"INSERT INTO books(
					title, author, pub_year, num_of_pages, lang, publisher, locality, isbn)
				VALUES
					(:title, :author, :pubYear, :numOfPages, :lang, :publisher, :locality, :isbn)";
			
			$stmt = $db->prepare($sql);
			$stmt->execute([
				':title' 	   => $title,
				':author' 	   => $authorId,
				':pubYear' 	   => $pubYear,
				':numOfPages'  => $numOfPages,
				':lang' 	   => $langId,
				':publisher'   => $publisherId,
				':locality'    => $localityId,
				':isbn' 	   => $isbn
			]);

		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
	}


	/**
	 * Get all the fields of the book 'id'
	 * 
	 * @param    int    $id    ID of the book
	 * 
	 * @return   array         The book info as an associative array
	 */
	public static function getBook($id)
	{
		try {
			$db = static::getDb();
			$sql =
				"SELECT
					books.id,
					books.title AS 'title',
					authors.name AS 'author',
					books.pub_year AS 'pubYear',
					books.num_of_pages AS 'numOfPages',
					langs.name AS 'lang',
					publishers.name AS 'publisher',
					localities.name AS 'locality',
					books.isbn
				FROM books
					LEFT JOIN authors ON books.author = authors.id
					LEFT JOIN langs ON books.lang = langs.id
					LEFT JOIN publishers ON books.publisher = publishers.id
					LEFT JOIN localities ON books.locality = localities.id
				WHERE books.id = :id
				LIMIT 1";

				$stmt = $db->prepare($sql);
				$stmt->execute([':id' => $id]);

				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

				return $results;

		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
	}

	
	/**
	 * Edit the book with the given params
	 * @param  array $book All of the params of the book as an array
	 * @return void
	 */
	public static function edit($book)
	{
		try {

			$db = static::getDb();
			$sql = 
				"UPDATE books
				SET
					title = :title,
					author = :authorId,
					pub_year = :pubYear,
					num_of_pages = :numOfPages,
					lang = :langId,
					publisher = :publisherId,
					locality = :localityId,
					isbn = :isbn
				WHERE id = :id";
				
			// Apply ':' prefix to array keys
			$book = array_combine(
				array_map(function($k){ return ':'.$k; }, array_keys($book)),
				$book
			);

			$stmt = $db->prepare($sql);
			$stmt->execute($book);

		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
	}


	/**
	 * Delete the row with id = $id from table 'books'
	 * 
	 * @param  int        $id    Id of the book to delete
	 * @return boolean			 Returns true in case of success
	 */
	public static function delete($id)
	{
		try {

			$db = static::getDb();

			$sql = 
				"DELETE FROM books
				WHERE id = '$id' LIMIT 1";
			
			$stmt = $db->query($sql);

			return true;

		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
	}

	/**
	 * Clean up the DB of unused params
	 * 
	 * Perform a LEFT OUTER JOIN ON 'authors', 'langs', 'localities' and
	 * 'publishers' with 'books' and select all NULL-ed rows and delete them
	 * 
	 * @return void
	 */
	public static function dbCleanUp()
	{
		// Array of tables
		$tables = [
			'authors' 		=> 'author',
			'langs' 		=> 'lang',
			'localities' 	=> 'locality',
			'publishers' 	=> 'publisher'
		];

		try {

			$db = static::getDb();

			// Iterate through each table to find and delete unused key
			foreach ($tables as $elements => $element) {
				
				// Perform the search
				$sql = 
					"SELECT $elements.id, $elements.name
					FROM $elements
					LEFT JOIN books
					ON $elements.id = books.$element
					WHERE books.$element IS NULL";
				$stmt = $db->query($sql);
				$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

				// Check if there are any results
				if ($results) {
					
					// Aggregate the ids
					$ids = [];
					for ($i=0; $i<count($results); $i++){
						$ids[] = "'" . $results[$i]['id'] . "'";
					}
					$ids = implode(',', $ids);

					// Delete from the database unused keys of table $elements
					$sql = 
						"DELETE FROM $elements
						WHERE id IN ($ids)";
					$stmt = $db->query($sql);
				}				
			}

		} catch (PDOException $e) {
			throw new \Exception($e->getMessage());
		}
	}

}