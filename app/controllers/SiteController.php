<?php
namespace App\Controllers;
use Pure\Bases\Controller;
use Pure\Utils\Request;
use Pure\Utils\Auth;
use App\Models\Category;
use App\Models\Event;

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
		$this->render('index', 'main');
	}

	public function iframe_action()
	{
		$this->render('index', 'none');
	}

	public function ajax_list_action() {
		$events = Event::find_all_informations();
		foreach($events as $event)
		{
			array_push($this->data,[
				'id' => $event->id,
				'title' => $event->name,
				'start' => $event->starts_at,
				'end' => $event->ends_at,
				'color' => $event->color
			]);
		}
		$this->render_json();
	}

	public function ajax_event_action($id) {
		$event = Event::find($id);
		$this->data['event'] = $event;
		$this->render_ajax('event/item');
	}

	/**
	 * Verifica se usuário está logado
	 */
	public function before()
	{
	}

}
