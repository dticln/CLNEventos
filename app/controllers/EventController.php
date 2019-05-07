<?php
namespace App\Controllers;
use Pure\Bases\Controller;
use Pure\Utils\Request;
use Pure\Utils\Auth;
use Pure\Utils\Res;
use App\Models\Event;
use App\Models\Category;
use Pure\Db\Database;
use App\Utils\Helpers;

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
				$response = $this->insertion_procedure(
					$infos['new-event-name'],
					$infos['new-event-place'],
					$infos['new-event-category'],
					$infos['new-event-start'],
					$infos['new-event-end'],
					$infos['new-event-body']
				);
			} else {
				$response = Res::arr('event_insert_fail');
			}
			$this->render_modal_response($response);
			exit();
		} else {
			$this->data['categories'] = Category::find();
			$this->render_ajax('event/insert');
			exit();
		}
	}

	public function ajax_update_action($id)
	{
		if (Request::is_POST()) {
			$infos = $this->params->unpack('POST', [
				'update-event-id',
				'update-event-name',
				'update-event-place',
				'update-event-category',
				'update-event-start',
				'update-event-end',
				'update-event-body'
			]);
			if ($infos)
			{
				$response = $this->update_procedure(
					intval($infos['update-event-id']),
					$infos['update-event-name'],
					$infos['update-event-place'],
					$infos['update-event-category'],
					$infos['update-event-start'],
					$infos['update-event-end'],
					$infos['update-event-body']
				);
			} else {
				$response = Res::arr('event_update_fail');
			}
			$this->render_modal_response($response);
			exit();
		} else {
			$this->data['event'] = Event::find(intval($id));
			if($this->data['event']) {
				$this->data['categories'] = Category::find();
				$this->render_ajax('event/update');
				exit();
			}
			http_response_code(400);
		}
	}

	public function ajax_delete_action($id)
	{
		if (Request::is_POST())
		{
			$id = $this->params->from_POST('event-id');
			$response = $this->exclusion_procedure($id);
			$this->render_modal_response($response);
		}
		else if (intval($id))
		{
			$this->data['event'] = Event::find(intval($id));
			$this->render_ajax('event/delete');
			exit();
		}
		http_response_code(400);
	}

	public function before()
	{
		if (!Auth::is_authenticated())
		{
			Request::redirect('login/do&callback=' . $this->params->from_GET('PurePage'));
		}
	}

	private function insertion_procedure($name, $place, $category_id, $start, $end, $body)
	{
		$database = Database::get_instance();
		$response = [];
		try {
			$database->begin();
			$start_date = strtotime(str_replace('/', '-', $start));
			$end_date = strtotime(str_replace('/', '-', $end));
			if ($start_date > $end_date) {
				$database->rollback();
				$response = Res::arr('event_insert_date_fail');
				return $response;
			}
			$new = new Event();
			$new->name = $name;
			$new->place = $place;
			$new->starts_at = date('Y-m-d H:i:s', $start);
			$new->ends_at = date('Y-m-d H:i:s', $end);
			$new->description = $body;
			$new->owner = $this->session->get('uinfo')->id;
			$category = Category::find($category_id);
			if ($category)
			{
				$new->category = $category->id;
				Event::save($new);
				$s = Res::arr('event_insert_success');
				$response = [
					'title' => $s['title'],
					'body' => $s['body_p1'] . $new->name . $s['body_p2']
				];
			} else
			{
				$database->rollback();
				$response = Res::arr('event_insert_fail');
				return $response;
			}
			$database->commit();
		}
		catch(\Exception $ex)
		{
			$database->rollback();
			$response = Res::arr('db_error');
		}
		return $response;
	}

	private function update_procedure($id, $name, $place, $category_id, $start, $end, $body)
	{
		$database = Database::get_instance();
		$response = [];
		try {
			$database->begin();
			$event = Event::find($id);
			if($event) {
				$start_date = strtotime(str_replace('/', '-', $start));
				$end_date = strtotime(str_replace('/', '-', $end));
				if ($start_date > $end_date) {
					$database->rollback();
					$response = Res::arr('event_update_date_fail');
					return $response;
				}
				$event->name = $name;
				$event->place = $place;
				$event->starts_at = date('Y-m-d H:i:s', $start_date);
				$event->ends_at = date('Y-m-d H:i:s', $end_date);
				$event->description = $body;
				$event->owner = $this->session->get('uinfo')->id;
				$category = Category::find($category_id);
				if ($category) {
					$event->category = $category->id;
					Event::save($event);
					$s = Res::arr('event_update_success');
					$response = [
						'title' => $s['title'],
						'body' => $s['body_p1'] . $event->name . $s['body_p2']
					];
				} else
				{
					$database->rollback();
					$response = Res::arr('event_update_fail');
					return $response;
				}
			} else
			{
				$database->rollback();
				$response = Res::arr('event_update_fail');
				return $response;
			}
			$database->commit();
		}
		catch(\Exception $ex)
		{
			$database->rollback();
			$response = Res::arr('db_error');
		}
		return $response;
	}

	private function exclusion_procedure($id)
	{
		$response = [];
		if(intval($id))
		{
			$database = Database::get_instance();
			try {
				$database->begin();
				$event = Event::find($id);
				if ($event)
				{
					Event::delete()->where(['id' => $event->id])->execute();
					$s = Res::arr('event_delete_success');
					$response = [
						'title' => $s['title'],
						'body' => $s['body_p1'] . $event->name .  $s['body_p2']
					];
				}
				else
				{
					$response = Res::arr('event_delete_fail');
				}
				$database->commit();
			}
			catch(\Exception  $ex)
			{
				$database->rollback();
				$response = Res::arr('db_error');
			}
		}
		return $response;
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
