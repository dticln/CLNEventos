<?php
namespace App\Controllers;
use Pure\Bases\Controller;
use Pure\Routes\Route;
use Pure\Utils\Request;
use App\Models\User;
use App\Models\Password;
use App\Utils\UFRGSAuth;
use Pure\Utils\Auth;
use Pure\Routes\UrlManager;
use App\Utils\Helpers;

/**
 * Controller de autenticação de usuário
 * Rotas válidas para autenticação no ambiente de desenvolvimento (development: localhost) e
 * no ambiente de produção (production: ufrgs.br).
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class LoginController extends Controller
{

	public function reset_action($username)
	{
		if(PURE_ENV === 'development' && intval($username)){
			$user = User::find(['ufrgs' => intval($username), 'is_activated' => true]);
			if ($user) {
				$new = Helpers::get_rnd_str(10);
				$pass = new Password($new);
				$id = Password::save($pass);
				$user->password = $id;
				User::save($user);
				echo '<pre> Nova senha para ' . $username . ': ' . $new . '</pre>';
				exit();
			}
		}
		Request::redirect('error/index');
	}

	public function do_action()
	{
		if(PURE_ENV === 'development')
		{
			$credential = $this->params->unpack('POST', ['ufrgs_id', 'password']);
			if(Request::is_POST() && $credential)
			{
				if($this->do_login($credential))
				{
					$this->redirect_to_callback();
					exit();
				}
			}
			$this->render('login', 'minimal');
			exit();
		} else
		{
			UFRGSAuth::authenticate();
			if(Auth::is_authenticated())
			{
				$this->redirect_to_callback();
			} else {
				Request::redirect('error/deny');
			}
		}
	}

	public function exit_action()
	{
		if(PURE_ENV === 'development')
		{
			Auth::revoke();
		} else
		{
			UFRGSAuth::revoke();
		}
		Request::redirect('login/do');
	}

	public function before()
	{
		$allow = [new Route('login', 'exit')];
		if(Auth::is_authenticated() && !Request::is_to($allow))
		{
			Request::redirect('site/index');
		}
	}

	private function do_login($credential = 0)
	{
		$user = User::find(['ufrgs' => intval($credential['ufrgs_id']), 'is_activated' => true]);
		if($user === null)
		{
			$this->data['error_message'] = 'Cartão UFRGS não encontrado.';
		} else if (!Password::compare(Password::find($user->password), $credential['password']))
		{
			$this->data['error_message'] = 'A senha está errada.';
		} else {
			Auth::authenticate($user->id, $user);
			return true;
		}
		return false;
	}

	private function redirect_to_callback() {
		$callback = $this->params->from_GET('callback');
		if(Request::has_route($callback)) {
			Request::redirect($callback);
		} else {
			Request::redirect('site/index');
		}
	}
}