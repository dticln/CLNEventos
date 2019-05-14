<?php
namespace App\Models;
use Pure\Bases\Model;
use App\Models\Permission;

/**
 * Representa um usuário na camada de Modelagem,
 * ou seu repositório
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class User extends Model
{
	public $ufrgs;
	public $name;
	public $password;
	public $is_activated;
	public $created;

	/**
	 * Verifica a permissão de determinado usuário de acordo com o cartão UFRGS
	 * e a HASH que representa a permissão
	 *
	 * @param mixed $ufrgs_id cartão UFRGS
	 * @param mixed $permission_name hash da permissão
	 * @return mixed resposta
	 */
	static function has_permission($ufrgs_id, $permission_name)
	{
	/*
		$it = Permission::select('permission.hash')
			->join('user_permission rel')
			->on('permission.id = rel.permission')
			->join('user usr')
			->on('usr.id = rel.user')
			->where(['usr.ufrgs' => intval($ufrgs_id), 'usr.is_activated' => true, 'permission.hash' => $permission_name])
			->execute();
		return isset($it[0]) ? $it[0] : false;*/
	}

	/**
	 * Procura usuário em banco de dado por cartão UFRGS ou nome
	 * @param mixed $search
	 * @return \array|boolean usuário
	 */
	static function find_by_name_or_ufrgs($search)
	{
		if(intval($search)) {
			return self::build('SELECT * FROM user WHERE name LIKE "%' .
				$search .
				'%" OR ufrgs LIKE "%' .
				intval($search) .
				'%" ORDER BY is_activated DESC, name ASC' )->execute();
		}
		return self::build('SELECT * FROM user WHERE name LIKE "%' .
				$search .
				'%" ORDER BY is_activated DESC, name ASC' )->execute();

	}

}
