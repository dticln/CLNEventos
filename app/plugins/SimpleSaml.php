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

	public function require_auth()
	{
		$this->instance->requireAuth(
			['ReturnTo' => ENV_SP_RETURN_TO]
		);
	}

	public function is_authenticated()
	{
		return $this->instance->isAuthenticated();
	}

	public function logout(){
		$this->instance->logout(
			['ReturnTo' => ENV_SP_RETURN_TO]
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
			$association = explode(":", $current);

			array_push($user->association, [
				'state' => ($association[0] == 'ativo') ,
				'id' => $association[1],
				'name' => $association[2],
				'to' => $association[10] == 'NULL' ? $association[10] : null,
				'from' => $association[11]  == 'NULL' ? $association[11] : null
			]);
		}
		return $user;
	}


}