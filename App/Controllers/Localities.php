<?php
namespace App\Controllers;

use Core\View;
use App\Models\Locality;

/**
 * Localities controller
 */
class Localities extends \Core\Controller
{
	/**
	 * Show the index page
	 *
	 * @return void
	 */
	public function indexAction()
	{
		$localities = Locality::getAll();

		// Format the singular/plural of books quantity
		foreach ($localities as $key => $value) {
			$localities[$key]['cnt'] = $this->pluralFormat(
				$localities[$key]['cnt'],
				'carte', 'cărți');
		}

		View::renderTemplate(
			'Localities/index.html',
			['localities' => $localities]
		);
	}

	/**
	 * Show all the books published in locality 'id'
	 *
	 * @param int $id id of the locality
	 * @return void
	 */
	public function inAction($id)
	{
		$data['books'] = Locality::in($id);
		$data['title'] = 'Cărți editate în ' . $data['books'][0]['locality'];
		
		View::renderTemplate(
			'Books/index.html',
			['data' => $data]
		);
	}
}