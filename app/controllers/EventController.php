<?php
namespace App\Controllers;
use Pure\Bases\Controller;
use Pure\Utils\Request;
use Pure\Utils\Auth;
use Pure\Utils\Res;
use App\Models\Event;
use App\Models\Category;
use Pure\Routes\UrlManager;


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
		if (Request::is_POST()) {
			$infos = $this->params->unpack('POST', [
				'new-event-name',
				'new-event-place',
				'new-event-category',
				'new-event-start',
				'new-event-end',
				'new-event-body'
			]);
			if ($infos) {
				// @todo cadastrar
				$response = [ 'title' => 'a', 'body' => 'b', 'modal' => true];
			} else {
				$response = Res::arr('event_insert_error');
			}
			$this->render_modal_response($response);
			exit();
		} else {
			$this->data['categories'] = Category::find();
			$this->render_ajax('event/insert');
			exit();
		}
	}

	/**
	 * Verifica se usuário está logado
	 */
	public function before()
	{
		if (!Auth::is_authenticated())
		{
			Request::redirect('login/do&callback=' . $this->params->from_GET('PurePage'));
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
