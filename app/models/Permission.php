<?php
namespace App\Models;
use Pure\Bases\Model;

/**
 * Representa uma permissão na camada de Modelagem,
 * ou seu repositório
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class Permission extends Model
{
	public $name;
	public $hash;
	public $description;
	public $created;
}