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
		$saml->require_auth();
		if($saml->is_authenticated()){
			$uinfo = $saml->get_attributes();
			$user = User::find(['ufrgs' => intval($uinfo->ufrgs), 'is_actived' => '1']);
			if($user) {
				if($user->name == '') {
					self::name_registration($user, $uinfo->name);
				}
				$session = Session::get_instance();
				$security = Security::get_instance();
				$uinfo->id = $user->id;
				$session->set('uid', $uinfo->ufrgs);
				$session->set('uinfo', $uinfo);
				$session->set('session_owner', $security->session_name());
				return true;
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
		$saml->logout();
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

}