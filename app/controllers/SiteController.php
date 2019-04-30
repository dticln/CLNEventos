<?php
namespace App\Controllers;
use Pure\Bases\Controller;
use Pure\Utils\Request;
use Pure\Utils\Auth;

/**
 * Controller principal
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class SiteController extends Controller
{

	public function index_action()
	{
		$this->render('index', 'minimal');
	}

	/**
	 * Verifica se usuário está logado
	 */
	public function before()
	{
		if (!Auth::is_authenticated())
		{
			Request::redirect('login/do');
		}
	}

}
