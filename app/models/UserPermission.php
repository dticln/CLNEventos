<?php
namespace App\Models;
use Pure\Bases\Model;

/**
 * Representa um relacionamento entre um usuário e uma permissão
 * na camada de modelagem.
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class UserPermission extends Model
{
	public $user;
	public $permission;
	public $created;
}