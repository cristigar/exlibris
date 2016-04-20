<?php
namespace App\Controllers;

use Core\View;
use App\Models\Publisher;

/**
 * Publishers controller
 */
class Publishers extends \Core\Controller
{
	/**
	 * Show the index page
	 *
	 * @return void
	 */
	public function indexAction()
	{
		$publishers = Publisher::getAll();

		// Format the singular/plural of books quantity
		foreach ($publishers as $key => $value) {
			$publishers[$key]['cnt'] = $this->pluralFormat(
				$publishers[$key]['cnt'],
				'carte', 'cărți');
		}

		View::renderTemplate(
			'Publishers/index.html',
			['publishers' => $publishers]
		);
	}

	/**
	 * Show all the books published by 'id'
	 *
	 * @param int $id id of the publisher
	 * @return void
	 */
	public function byAction($id)
	{
		$data['books'] = Publisher::by($id);
		$data['title'] = 'Cărți editate de ' . $data['books'][0]['publisher'];
		
		View::renderTemplate(
			'Books/index.html',
			['data' => $data]
		);
	}
}