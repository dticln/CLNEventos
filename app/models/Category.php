<?php
namespace App\Models;
use Pure\Bases\Model;

/**
 * Representa uma categoria na camada de Modelagem,
 * ou seu repositório
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class Category extends Model
{
	public $name;
	public $description;
	public $basecolor;
	public $created;
}