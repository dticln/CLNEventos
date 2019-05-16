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
	 * Realiza a autenticação utilizando SimpleSAML na Federação UFRGS (SP Shibboleth).
	 *
	 * A verificação de acesso é feita em self::has_access($uinfo), onde estão contidas as regras
	 * de vínculos que serão aceitas pelo sistema (Ex.: técnicos, docentes e alunos com vínculo ativo no CLN)
	 *
	 * O acesso ao sistema pode ser negado, caso o usuário conste como desativado no DB da aplicação.
	 * Caso o usuário nunca tenha realizado login no sistema, uma entrada com informações básicas será criada no DB.
	 *
	 * @return boolean resposta
	 */
	public static function authenticate()
	{
		$saml = new SimpleSaml();
		$saml->require_auth();
		if($saml->is_authenticated()){
			$uinfo = $saml->get_attributes();
			if(self::has_access($uinfo)) {
				$user = User::find(['ufrgs' => intval($uinfo->ufrgs)]);
				if($user) {
					if($user->is_activated == false) {
						return false;
					}
				} else {
					$user = new User();
					$user->ufrgs = intval($uinfo->ufrgs);
					$user->name = $uinfo->name;
					$user->is_activated = true;
					$user->id = User::save($user);
				}
				$security = Security::get_instance();
				$session = Session::get_instance();
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

	/**
	 * Realiza a verificação de vínculos com a Universidade
	 * Os vínculos são verificados em três funções:
	 *
	 * - employee_access_by_exercise verifica se, dentro dos vínculos,
	 * o usuário está em exercício no CLN.
	 * - employee_access_by_position verifica se o usuário está lotado no CLN.
	 * - student_access_by_course verifica se o usuário é aluno de algum dos cursos
	 * do CLN.
	 *
	 * @param mixed $uinfo objeto obtido pelo SP
	 * @return boolean
	 */
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

	/**
	 * Verifica se o usuário está lotado no CLN, com base nos dados de vínculos.
	 *
	 * @param mixed $association vínculos com a universidade
	 * @return boolean
	 */
	private static function employee_access_by_exercise($association) {
		return (strpos($association['exercise_ou_name'], ENV_SP_CLN_NEEDLE) !== false);
	}

	/**
	 * Verifica se o usuário está em exercício no CLN, com base nos dados de vínculos.
	 *
	 * @param mixed $association vínculos com a universidade
	 * @return boolean
	 */
	private static function employee_access_by_position($association) {
		return (strpos($association['position_ou_name'], ENV_SP_CLN_NEEDLE) !== false);
	}

	/**
	 * Verifica se o usuário é um estudante de algum curso do CLN.
	 * @todo
	 *
	 * @param mixed $association vínculos com a universidade
	 * @return boolean
	 */
	private static function student_access_by_course($association) {
		return false;
	}

}