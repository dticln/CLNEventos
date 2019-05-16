<?php
namespace App\Plugins;
use Pure\Bases\Plugin;


/**
 * SimpleSaml short summary.
 *
 * SimpleSaml description.
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class SimpleSaml extends Plugin
{

	public $instance;

	public function __construct() {
		$autoloaders = self::pre_execute();
		require_once(ENV_SP_PATH);
		$this->instance = new \SimpleSAML_Auth_Simple(ENV_SP_AUTH_TOKEN);
		self::post_execute($autoloaders);
	}

	public static function pre_execute()
	{
		$autoloaders = spl_autoload_functions();
		foreach($autoloaders as $function) {
			spl_autoload_unregister($function);
		}
		return $autoloaders;
	}

	public static function post_execute($autoloaders)
	{
		foreach($autoloaders as $function) {
			spl_autoload_register($function);
		}
	}

	public function source() {}

	public function require_auth($return_to = ENV_SP_RETURN_TO)
	{
		$this->instance->requireAuth(
			['ReturnTo' => $return_to]
		);
	}

	public function is_authenticated()
	{
		return $this->instance->isAuthenticated();
	}

	public function logout($return_to = ENV_SP_RETURN_TO){
		$this->instance->logout(
			['ReturnTo' => $return_to]
		);
		exit();
	}

	public function get_logout_url(){
		return $this->instance->getLogoutURL();
	}

	public function get_attributes()
	{
		$attributes = $this->instance->getAttributes();
		$user = new \stdClass();
		$user->ufrgs = $attributes[ENV_SP_UFRGS_ID][0];
		$user->name = $attributes[ENV_SP_FIRST_NAME][0] . ' ' . $attributes[ENV_SP_SECOND_NAME][0];
		$user->email = $attributes[ENV_SP_EMAIL][0];
		$user->association = [];
		foreach($attributes[ENV_SP_ASSOCIATION] as $current)
		{
			array_push($user->association, $this->normalize_association($current));
		}
		return $user;
	}

	private function normalize_association($raw_association)
	{
		$association = explode(":", $raw_association);
		return [
			'bond_state' => ($association[0] == 'ativo'),
			'bond_code' => intval($association[1]),
			'bond_name' => $association[2],
			'exercise_ou_code' => intval($association[3]),
			'exercise_ou_name' => ($association[4] !== 'NULL') ? $association[4] : null,
			'position_ou_code' => intval($association[5]),
			'position_ou_name' => ($association[6] !== 'NULL') ? $association[6] : null,
			'course_code' => intval($association[7]),
			'course_name' => ($association[8] !== 'NULL') ? $association[8] : null,
			'starts' => ($association[9] !== 'NULL') ? $association[9] : null,
			'ends' => ($association[10] !== 'NULL') ? $association[10] : null,
		];
	}


}