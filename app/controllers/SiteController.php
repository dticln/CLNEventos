<?php
namespace App\Controllers;
use Pure\Bases\Controller;
use Pure\Utils\Request;
use App\Models\Article;
use App\Models\Category;
use Pure\Utils\Auth;
use App\Models\Link;
use Pure\Utils\Session;

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
		echo 'Hello world!';
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
