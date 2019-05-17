<?php
namespace App\Controllers;
use Pure\Bases\Controller;
use Pure\Utils\Request;
use Pure\Utils\Auth;
use Pure\Utils\Res;
use App\Models\Event;
use App\Models\Category;
use Pure\Db\Database;
use Pure\Utils\Session;

/**
 * Controller utilizado na administração de eventos
 *
 * Os métodos aqui descritos são utilizados na inclusão, exclusão,
 * edição e atualização de eventos
 */
class EventController extends Controller
{

	/**
	 * Página principal da area de administração de eventos
	 */
	public function index_action()
	{
		$this->render('event/index', 'dashboard');
	}

	/**
	 * Lista o eventos cadastrados em banco de dados.
	 *
	 * O método carrega a lista de eventos no painel principal de EventController:index,
	 * sendo chamado por uma requisição Ajax.
	 *
	 * Realiza a consulta dos eventos do usuário, quando o usuário não tem permissão
	 * de administrador de eventos.
	 *
	 * Carrega todos os eventos de todos os usuários, quando o usuário tem permissão.
	 *
	 * Caso a variável $_GET['event-search'] está presente, realiza a consulta com uma pesquisa.
	 * Caso a variável $_GET['event-page'] está presente, realiza a consulta na paginação específica
	 * seu valor padrão é 1; sendo assim, por padrão, recupera os resultados da primeira página.
	 *
	 * Ambas as variaveis ($_GET['event-search'] e $_GET['event-page']) podem estar presentes.
	 */
	public function ajax_list_action()
	{
		$search = $this->params->from_GET('event-search');
		$page = $this->params->from_GET('event-page');
		$page = ($page) ? intval($page) : 1;
		$this->data['per_page'] = 10;
		$user = (PURE_ENV === 'production') ?
			Session::get_instance()->get('uinfo')->id :
			Session::get_instance()->get('uid');
		if($search) {
			$this->data['events'] = Event::select_at_page_where(
				$user,
				trim($search),
				$this->data['per_page'],
				$page
			);
			$this->data['count'] = Event::select_count_where($user, trim($search));
		} else
		{
			$this->data['events'] = Event::select_at_page(
				$user,
				$this->data['per_page'],
				$page
			);
			$this->data['count'] = Event::select_count($user);
		}
		foreach($this->data['events'] as $event) {
			$event->finished = (strtotime($event->ends_at) <= strtotime('now'));
		}
		$this->data['page'] = $page;
		$this->data['search'] = trim($search);
		$this->render_ajax('event/list');
	}

	/**
	 * Responsável pela inserção de um novo evento no banco de dados.
	 *
	 * POST - O método insere um novo evento no banco de dados através de uma
	 * requisição Ajax.
	 * Para uma inserção bem sucedida, a variável $_POST deve possuir os campos:
	 * - new-event-name: nome do evento
	 * - new-event-place: local onde o evento ocorrerá
	 * - new-event-category: id da categoria (a categoria deve existir no banco de dados)
	 * - new-event-start: data de início do evento
	 * - new-event-end: data de término do evento (deve ser superior à data de início)
	 * - new-event-body: corpo de descrição do evento
	 * Realiza a chamada do método $this->insertion_procedure(...) para realizar o cadastramento.
	 *
	 * GET - Carrega o formulário de inserção de um novo evento do banco de dados
	 * através de uma requisição Ajax.
	 */
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
			} else
{
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

	/**
	 * Responsável pela atualização de um evento no banco de dados.
	 *
	 * POST - O método atualiza um evento no banco de dados através de uma
	 * requisição Ajax.
	 * Para uma atualização bem sucedida, a variável $_POST deve possuir os campos:
	 * - update-event-name: nome do evento
	 * - update-event-place: local onde o evento ocorrerá
	 * - update-event-category: id da categoria (a categoria deve existir no banco de dados)
	 * - update-event-start: data de início do evento
	 * - update-event-end: data de término do evento (deve ser superior à data de início)
	 * - update-event-body: corpo de descrição do evento
	 * Realiza a chamada do método $this->update_procedure(...) para realizar a atualização.
	 *
	 * GET - Carrega o formulário de atualização de evento do banco de dados
	 * através de uma requisição Ajax.
	 * A requisição necessita ter, em sua URL, o id do evento que será atualizado.
	 */
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
			exit();
		}
	}

	/**
	 * Responsável pela exclusão de um evento no banco de dados.
	 *
	 * POST - O método exclui um evento no banco de dados através de uma
	 * requisição Ajax.
	 * Para uma exclusão bem sucedida, a variável $_POST deve possuir
	 * o campo event-id (identificador do evento).
	 * Realiza a chamada do método $this->exclusion_procedure(...) para realizar a atualização.
	 *
	 * GET - Carrega o formulário de confirmação de exclusão de evento do banco de dados
	 * através de uma requisição Ajax.
	 * A requisição necessita ter, em sua URL, o id do evento que será excluído.
	 */
	public function ajax_delete_action($id)
	{
		if (Request::is_POST())
		{
			$id = $this->params->from_POST('event-id');
			$response = $this->exclusion_procedure($id);
			$this->render_modal_response($response);
			exit();
		}
		else if (intval($id))
		{
			$this->data['event'] = Event::find(intval($id));
			$this->render_ajax('event/delete');
			exit();
		}
		http_response_code(400);
	}

	/**
	 * Verificação de autenticação
	 * Os usuários devem ter uma sessão ativa para acessar os métodos do controller.
	 */
	public function before()
	{
		if (!Auth::is_authenticated())
		{
			Request::redirect(
				((PURE_ENV === 'development') ? 'login/do&callback=' : 'login/do/&callback=') .
				$this->params->from_GET('PurePage')
			);
		}
	}

	/**
	 * Realiza a inserção de um novo evento na base de dados,
	 * retornando um array com uma mensagem de feedback para o usuário.
	 *
	 * @param string $name nome do evento
	 * @param string $place local onde o evento ocorrerá
	 * @param int $category_id id de uma categoria (deve estar presente no banco de dados)
	 * @param string $start data de início do evento
	 * @param string $end data de término do evento
	 * @param string $body corpo de descrição do evento
	 * @return array ['title' => 'Some title', 'body' => 'Some body'] feedback
	 */
	private function insertion_procedure($name, $place, $category_id, $start, $end, $body)
	{
		$database = Database::get_instance();
		$response = [];
		try {
			$database->begin();
			$start_date = strtotime(str_replace('/', '-', $start));
			$end_date = strtotime(str_replace('/', '-', $end));
			if ($start_date >= $end_date) {
				$database->rollback();
				$response = Res::arr('event_insert_date_fail');
				return $response;
			}
			$new = new Event();
			$new->name = substr($name, 0, Event::$NAME_LENGTH);
			$new->place = substr($place, 0, Event::$PLACE_LENGTH);
			$new->starts_at = date('Y-m-d H:i:s', $start_date);
			$new->ends_at = date('Y-m-d H:i:s', $end_date);
			$new->description = substr($body, 0, Event::$DESCRIPTION_LENGTH);
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

	/**
	 * Realiza a atualização de um evento na base de dados,
	 * retornando um array com uma mensagem de feedback para o usuário.
	 *
	 * @param int $id identificador do evento
	 * @param string $name nome do evento
	 * @param string $place local onde o evento ocorrerá
	 * @param int $category_id id de uma categoria (deve estar presente no banco de dados)
	 * @param string $start data de início do evento
	 * @param string $end data de término do evento
	 * @param string $body corpo de descrição do evento
	 * @return array ['title' => 'Some title', 'body' => 'Some body'] feedback
	 */
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
				if ($start_date >= $end_date) {
					$database->rollback();
					$response = Res::arr('event_update_date_fail');
					return $response;
				}
				$event->name = substr($name, 0, Event::$NAME_LENGTH);
				$event->place = substr($place, 0, Event::$PLACE_LENGTH);
				$event->starts_at = date('Y-m-d H:i:s', $start_date);
				$event->ends_at = date('Y-m-d H:i:s', $end_date);
				$event->description = substr($body, 0, Event::$DESCRIPTION_LENGTH);
				$event->owner = $this->session->get('uinfo')->id;
				$event->updated = date('Y-m-d H:i:s', strtotime('now'));
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
				}
			} else
			{
				$database->rollback();
				$response = Res::arr('event_update_fail');
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

	/**
	 * Realiza a exclusão de um evento na base de dados com base no identificador.
	 *
	 * @param int $id identificador de evento
	 * @return array ['title' => 'Some title', 'body' => 'Some body'] feedback
	 */
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
					$database->rollback();
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

	/**
	 * Cria o código HTML que será inflado em um modal.
	 * Recebe um array com título e corpo, conforme @param.
	 *
	 * @param array $package ['title' => 'Some title', 'body' => 'Some body']
	 */
	private function render_modal_response($package)
	{
		$this->data['title'] = $package['title'];
		$this->data['body'] = $package['body'];
		$this->data['modal'] = true;
		$this->render_ajax('response');
		exit();
	}
}
