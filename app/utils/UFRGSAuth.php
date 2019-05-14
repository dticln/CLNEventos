<?php
namespace App\Utils;
use Pure\Utils\Session;
use Pure\Utils\Security;
use App\Plugins\SimpleSaml;
use App\Models\User;

/**
 * Classe de autenticação personalizada para realizar a
 * verificação de usuário no domínio da UFRGS
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class UFRGSAuth
{

	/**
	 * Registra um novo nome junto ao cartão em banco
	 * Utilizado primeiro login
	 *
	 * @param mixed $user id do usuário em banco
	 * @param mixed $name nome para o usuário
	 */
	private static function name_registration($user, $name)
	{
		User::update(['name' => $name])
			->where(['id' => $user->id])
			->execute();
	}

	/**
	 * Realiza a autenticação, caso o usuário faça login na federação
	 *
	 * @return boolean resposta
	 */
	public static function authenticate()
	{
		$saml = new SimpleSaml();
		$saml->require_auth($_SERVER['REQUEST_URI']);
		if($saml->is_authenticated()){
			$uinfo = $saml->get_attributes();
			Session::get_instance()->set('status', 'saml retrive');
			if(self::has_access($uinfo)) {
				Session::get_instance()->set('status', 'has access');
				$user = User::find(['ufrgs' => intval($uinfo->ufrgs)]);
				if($user) {
					Session::get_instance()->set('status', 'found user');
					if($user->is_activated == false) {
						Session::get_instance()->set('status', 'not activated');
						return false;
					} else {
						Session::get_instance()->set('status', 'activated');
					}
				} else {
					$user = new User();
					$user->ufrgs = intval($uinfo->ufrgs);
					$user->name = $uinfo->name;
					$user->is_activated = true;
					$user->id = User::save($user);
					Session::get_instance()->set('status', 'registered');
				}
				$session = Session::get_instance();
				$security = Security::get_instance();
				$uinfo->id = $user->id;
				$session->set('uid', $uinfo->ufrgs);
				$session->set('uinfo', $uinfo);
				$session->set('session_owner', $security->session_name());
				return true;
			} else {
				Session::get_instance()->set('status', 'has no access');
			}
		}
		return false;
	}

	/**
	 * Realiza o logout no servidor da UFRGS
	 */
	public static function revoke()
	{
		$saml = new SimpleSaml();
		$saml->logout($_SERVER['REQUEST_URI']);
		$session = Session::get_instance();
		$session->wipe('uid');
		$session->wipe('uinfo');
		$session->wipe('session_owner');
		$session->destroy();
	}

	/**
	 * Realiza verificação de permissão no usuário atual
	 *
	 * @param mixed $permission HASH de permissão
	 * @return boolean resposta
	 */
	public static function has_permission($permission)
	{
		$ufrgs = Session::get_instance()->get('uinfo')->ufrgs;
		$response = User::has_permission($ufrgs, $permission);
		return (!empty($response) && ($response->hash == $permission));
	}

	private static function has_access($uinfo)
	{
		Session::get_instance()->set('bond', []);
		foreach($uinfo->association as $a) {
			if ($a['bond_state'] === true) {
				array_push($_SESSION['bond'], $a['bond_name']);
				if (self::employee_access_by_exercise($a) ||
					self::employee_access_by_position($a) ||
					self::student_access_by_course($a)){
					Session::get_instance()->set('access_from', $a['bond_name']);
					return true;
				}
			}
		}
		return false;
	}

	private static function employee_access_by_exercise($association) {
		return (strpos($association['exercise_ou_name'], ENV_SP_CLN_NEEDLE) !== false);
	}

	private static function employee_access_by_position($association) {
		return (strpos($association['position_ou_name'], ENV_SP_CLN_NEEDLE) !== false);
	}

	private static function student_access_by_course($association) {
		return false;
	}

}