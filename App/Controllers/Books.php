<?php
namespace App\Controllers;

use Core\View;
use App\Models\Book;

/**
 * Books controller
 */
class Books extends \Core\Controller
{
	/**
	 * Show the index page
	 *
	 * @return void
	 */
	public function indexAction()
	{
		$data['books'] = Book::getAll();
		$data['title'] = "Toate cărțile";

		View::renderTemplate(
			'Books/index.html',
			['data' => $data]
		);
	}

	/**
	 * Show the search results
	 *
	 * @return void
	 */
	public function searchAction()
	{
		if (isset($_GET['q']) and isset($_GET['acc']) and $_GET['acc'] === '1') {
			
			// Using full accuracy

			// Trim search query
			$query = trim($_GET['q']);

			// Get search results
			$data['books'] = Book::search($_GET['q'], 1);

			// Set a custom title
			$data['title'] = "Rezultatele căutării pentru „" . $query . "”";

			// Add search query
			$data['q'] = $query;

			// Render the view
			View::renderTemplate(
				'Books/index.html',
				['data' => $data]
			);

		} else {
			
			// Get, trim and add the search query to final results
			$query = trim($_GET['q']);
			$data['q'] = $query;
			
			// Exclude all non-alphanumeric characters (Latin and Cyrillic)
			// and hyphen (-)
			$query = preg_replace(
				'/[^a-zA-Z\p{Cyrillic}0-9-]/u',
				'',
				$query);

			// Convert to lowercase
			$query = mb_strtolower($query);

			// Convert to array
			$arrayQuery = $this->mbStringToArray($query);

			// Get the search results
			$data['books'] = Book::search($arrayQuery);

			// Add a custom title
			$data['title'] = "Rezultatele căutării pentru „" . trim($_GET['q']) . "”";
			
			// Render the view
			View::renderTemplate(
				'Books/index.html',
				['data' => $data]
			);
			
		}

	}

	/**
	 * Multi-byte string-to-array conversion
	 * 
	 * @param  string $string String to convert
	 * @return array
	 */
	private function mbStringToArray($string)
	{
		$strlen = mb_strlen($string);
			while ($strlen) {
				$array[] = mb_substr($string, 0, 1, "UTF-8");
				$string = mb_substr($string, 1, $strlen, "UTF-8");
				$strlen = mb_strlen($string);
		}
		return $array;
	}

}