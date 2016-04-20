<?php
namespace App\Controllers;

use Core\View;
use App\Models\Author;

/**
 * Authors controller
 */
class Authors extends \Core\Controller
{
	/**
	 * Show the index page
	 *
	 * @return void
	 */
	public function indexAction()
	{
		$authors = Author::getAll();

		// Format the singular/plural of books quantity
		foreach ($authors as $key => $value) {
			$authors[$key]['cnt'] = $this->pluralFormat(
				$authors[$key]['cnt'],
				'carte', 'cărți');
		}

		View::renderTemplate(
			'Authors/index.html',
			['authors' => $authors]
		);
	}

	/**
	 * Show all the books written by the author 'id'
	 *
	 * @param int $id id of the author
	 * @return void
	 */
	public function byAction($id)
	{
		$data['books'] = Author::by($id);
		$data['title'] = 'Cărți ale autorului ' . $data['books'][0]['author'];
		
		View::renderTemplate(
			'Books/index.html',
			['data' => $data]
		);
	}
}