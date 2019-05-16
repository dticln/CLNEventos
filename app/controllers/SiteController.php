<?php
namespace App\Controllers;
use Pure\Bases\Controller;
use Pure\Utils\Request;
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
		$this->data['categories'] = Category::find();
		$this->render('index', 'main');
	}

	public function iframe_action()
	{
		$this->data['categories'] = Category::find();
		$this->render('index', 'none');
	}

	public function simplesaml_action()
	{
		if(PURE_ENV === 'production' && ENV_SP_DEV){
			echo '<pre>' . var_dump($this->session->get('uid')) . '</pre>';
			echo '<pre>' . var_dump($this->session->get('status')) . '</pre>';
			echo '<pre>' . var_dump($this->session->get('bond')) . '</pre>';
			echo '<pre>' . var_dump($this->session->get('access_from')) . '</pre>';
			echo '<pre>' . var_dump($this->session->get('session_owner')) . '</pre>';
			highlight_string("<?php\n\$data =\n" . var_export($this->session->get('uinfo'), true) . ";\n?>");
			exit();
		}
		Request::redirect('error/index');
	}

	public function ajax_list_action() {
		if (Request::is_POST()) {
			$param = $this->params->unpack('POST', ['start', 'end']);
			if ($param) {
				$events = Event::get_events_at_interval($param['start'], $param['end']);
				foreach($events as $event)
				{
					array_push($this->data,[
						'id' => $event->id,
						'title' => $event->name,
						'start' => $event->starts_at,
						'end' => $event->ends_at,
						'category' => $event->category_name,
						'color' => (strtotime($event->ends_at) <= strtotime('now')) ? '#606060' : $event->color
					]);
				}
			} else {
				array_push($this->data,[
					'message' => 'Requisição incorreta.'
				]);
			}
			$this->render_json();
		} else {
			Request::redirect('error/deny');
		}
	}

	public function ajax_event_action($id) {
		$event = Event::find($id);
		$this->data['event'] = $event;
		$this->data['event']->category = Category::find($event->category)->name;
		$this->render_ajax('event/item');
	}

	/**
	 * Verifica se usuário está logado
	 */
	public function before() {}

}
