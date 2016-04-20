<?php
namespace App\Controllers;

use Core\View;
use App\Models\Lang;

/**
 * Langs controller
 */
class Langs extends \Core\Controller
{
	/**
	 * Show the index page
	 *
	 * @return void
	 */
	public function indexAction()
	{
		$langs = Lang::getAll();

		// Format the singular/plural of books quantity
		foreach ($langs as $key => $value) {
			$langs[$key]['cnt'] = $this->pluralFormat(
				$langs[$key]['cnt'],
				'carte', 'cărți');
		}

		View::renderTemplate(
			'Langs/index.html',
			['langs' => $langs]
		);
	}

	/**
	 * Show all the books in language 'id'
	 *
	 * @param int $id id of the lang
	 * @return void
	 */
	public function inAction($id)
	{
		$data['books'] = Lang::in($id);
		$data['title'] = 'Cărți în limba ' . $data['books'][0]['lang'];
		
		View::renderTemplate(
			'Books/index.html',
			['data' => $data]
		);
	}
}