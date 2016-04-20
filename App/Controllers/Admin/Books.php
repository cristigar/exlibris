<?php
namespace App\Controllers\Admin;

use Core\View;
use App\Models\Book;

/**
 * Books controller
 */
class Books extends \Core\Controller
{
	/**
	 * Add a book to the database
	 *
	 * @return void
	 */
	public function addAction()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {

			// First visit actions
			// Get options values to use as datalist
			$tables = Book::getTables();

			// Populate the datalists with data from the DB
			View::renderTemplate(
				'Books/add.html',
				['tables' => $tables]
			);

		} else {
			
			// Receive and validate user input
			// title, author, numOfPages and lang are mandatory
			// others are not
			if (
				$title = filter_var($_POST['title'], FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp"=>'/^[^\/\?\%\*\:\|\"\<\>]+$/')))
				
				and
				
				$author = filter_var($_POST['author'], FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp"=>'/^[^\^<\"@\/\{\}\(\)\*\$%\?=>:\|;#\[\]]+$/i')))
				
				and (
					$pubYear = filter_var($_POST['pubYear'], FILTER_VALIDATE_INT,
					array("options"=>array("max_range"=> date("Y") )))
					or $pubYear == null
				)
				
				and
				
				$numOfPages = filter_var($_POST['numOfPages'], FILTER_VALIDATE_INT,
				array("options"=>array("min_range"=> 0 )))
				
				and
				
				$lang = mb_convert_case(
					filter_var($_POST['lang'], FILTER_VALIDATE_REGEXP,
					array("options"=>array("regexp"=>'/^[^\^<\"@\/\{\}\(\)\*\$%\?=>:\|;#\[\]]+$/i'))),
					MB_CASE_LOWER, "UTF-8")
				
				and (
					$publisher = filter_var($_POST['publisher'], FILTER_VALIDATE_REGEXP,
					array("options"=>array("regexp"=>'/^[^\^<\"@\/\{\}\(\)\*\$%\?=>:\|;#\[\]]+$/i')))
					or $publisher == null
				)

				and (				
					$locality = filter_var($_POST['locality'], FILTER_VALIDATE_REGEXP,
					array("options"=>array("regexp"=>'/^[^\^<\"@\/\{\}\(\)\*\$%\?=>:\|;#\[\]]+$/i')))
					or $locality == null
				)

				and (				
					$isbn = filter_var($_POST['isbn'], FILTER_VALIDATE_REGEXP,
					array("options"=>array("regexp"=>'/^[0-9]+[- ][0-9]+[- ][0-9]+[- ][0-9]*[- ]*[xX0-9]$/i')))
					or $isbn == null
				)
			) {
				
				// 'Good input' actions
				// Get the IDs of the received values
				$authorId 		= $this->getId($author, 'authors');
				$langId 		= $this->getId($lang, 'langs');
				$publisherId 	= $this->getId($publisher, 'publishers');
				$localityId 	= $this->getId($locality, 'localities');

				// Insert data into the DB
				Book::add(
					$title, $authorId, $pubYear, $numOfPages,
					$langId, $publisherId, $localityId, $isbn
				);

				// Redirect to 'books/index'
				header('Location: /books/index');

			} else {
				
				// 'Bad input' actions
				// Get options values to use as datalist
				$tables = Book::getTables();

				// Add the warning message
				$tables['message'] = 'Datele introduse nu sunt valide!';

				// Add the user data to display in input fields
				$tables['post'] = $_POST;

				// Render the view
				View::renderTemplate(
					'Books/add.html',
					['tables' => $tables]
				);

			}
		}
	}


	/**
	 * Edit the book with id = $id
	 * 
	 * @param  int    $id    Id of the book to be edited
	 * @return void
	 */
	public function editAction($id)
	{
		
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {

			// Get data about the book from the DB
			$book = Book::getBook($id)[0];

			// Get options values to use as datalist
			$tables = Book::getTables();

			// Aggregate the data
			$data = $tables;
			$data['book'] = $book;

			// Populate the input fields and datalists with data from the DB
			View::renderTemplate(
				'Books/edit.html',
				['data' => $data]
			);

		} else {
			
			// Receive and validate user input
			// title, author, numOfPages and lang are mandatory
			// others are not
			if (
				$id = filter_var($_POST['id'], FILTER_VALIDATE_INT)
				
				and

				$title = filter_var($_POST['title'], FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp"=>'/^[^\/\?\%\*\:\|\"\<\>]+$/')))
				
				and
				
				$author = filter_var($_POST['author'], FILTER_VALIDATE_REGEXP,
				array("options"=>array("regexp"=>'/^[^\^<\"@\/\{\}\(\)\*\$%\?=>:\|;#\[\]]+$/i')))
				
				and (
					$pubYear = filter_var($_POST['pubYear'], FILTER_VALIDATE_INT,
					array("options"=>array("max_range"=> date("Y") )))
					or $_POST['pubYear'] == null
				)
				
				and
				
				$numOfPages = filter_var($_POST['numOfPages'], FILTER_VALIDATE_INT,
				array("options"=>array("min_range"=> 0 )))
				
				and
				
				$lang = mb_convert_case(
					filter_var($_POST['lang'], FILTER_VALIDATE_REGEXP,
					array("options"=>array("regexp"=>'/^[^\^<\"@\/\{\}\(\)\*\$%\?=>:\|;#\[\]]+$/i'))),
					MB_CASE_LOWER, "UTF-8")
				
				and (
					$publisher = filter_var($_POST['publisher'], FILTER_VALIDATE_REGEXP,
					array("options"=>array("regexp"=>'/^[^\^<\"@\/\{\}\(\)\*\$%\?=>:\|;#\[\]]+$/i')))
					or $_POST['publisher'] == null
				)

				and (				
					$locality = filter_var($_POST['locality'], FILTER_VALIDATE_REGEXP,
					array("options"=>array("regexp"=>'/^[^\^<\"@\/\{\}\(\)\*\$%\?=>:\|;#\[\]]+$/i')))
					or $_POST['locality'] == null
				)

				and (				
					$isbn = filter_var($_POST['isbn'], FILTER_VALIDATE_REGEXP,
					array("options"=>array("regexp"=>'/^[0-9]+[- ][0-9]+[- ][0-9]+[- ][0-9]*[- ]*[xX0-9]$/i')))
					or $_POST['isbn'] == null
				)
			) {

				// 'Good input' actions
				// Get the IDs of the received values
				$authorId 		= $this->getId($author, 'authors');
				$langId 		= $this->getId($lang, 'langs');
				$publisherId 	= $this->getId($publisher, 'publishers');
				$localityId 	= $this->getId($locality, 'localities');

				// Aggregate the book information
				$book = compact(
					'id', 'title', 'authorId', 'pubYear', 'numOfPages',
					'langId', 'publisherId', 'localityId', 'isbn'
				);

				// Update the book information in the DB
				Book::edit($book);

				// Clean up the DB of unused values of book params
				Book::dbCleanUp();

				// Redirect to 'books/index'
				header('Location: /books/index');

			} else {

				// 'Bad input' actions
				// Get options values to use as datalist
				$data = Book::getTables();

				// Add the warning message
				$data['message'] = 'Datele introduse nu sunt valide!';

				// Add the user data to display in input fields
				$data['post'] = $_POST;

				// Render the view
				View::renderTemplate(
					'Books/edit.html',
					['data' => $data]
				);

			}
		}
	}


	/**
	 * Delete the book with id = $id
	 * 
	 * @param  int    $id    Id of the book to delete
	 * @return void
	 */
	public function deleteAction($id)
	{
		// Define the message holder
		$messages['main'] = '';

		// Check if the book was deleted and set the appropriate message
		if (Book::delete($id)) {
			Book::dbCleanUp();
			$messages['main'] = 'Cartea a fost ștearsă cu succes.';

			if ($_SERVER["HTTP_REFERER"]) {
				$messages['main'] .= ' <a href="'. $_SERVER["HTTP_REFERER"] .'">Dați clic</a> pentru a merge înapoi.';
			} else {
				$messages['main'] .= ' <a href="/">Dați clic</a> pentru a merge la pagina principală.';
			}
		} else {
			$messages['main'] = 'Au apărut probleme la ștergerea cărții.';
		}
		
		// Render the view with the message
		View::renderTemplate(
				'Books/delete.html',
				['messages' => $messages]
			);
	}


	/**
	 * Get the ID of a record in a table
	 * If the record is found then the ID is returned, otherwise a new value
	 * is inserted into the appropriate table
	 *
	 * @param string $value Value of the record to get the ID for
	 * @param string $table Table name
	 *
	 * @return int ID of the inserted/selected record
	 */
	private function getId($value, $table)
	{
		if ($res = Book::checkPresence($value, $table)) {
			return $res[0]['id'];
		} else {
			return Book::insertNew($value, $table);
		}
	}

}