<?php
namespace App\Controllers;
use Pure\Bases\Controller;
use Pure\Utils\Request;
use Pure\Utils\Auth;
use App\Models\Event;
use App\Models\Category;

/**
 * Controller principal
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class EventController extends Controller
{

	public function index_action()
	{
		$this->render('event/index', 'dashboard');
	}

	public function ajax_list_action()
	{
		$this->data['events'] = Event::find_all_informations();
		$this->render_ajax('event/list');
	}

	public function ajax_insert_action()
	{
		$this->data['categories'] = Category::find();
		$this->render_ajax('event/insert');
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

	private function render_modal_response($package)
	{
		$this->data['title'] = $package['title'];
		$this->data['body'] = $package['body'];
		$this->data['modal'] = true;
		$this->render_ajax('response');
		exit();
	}
}
