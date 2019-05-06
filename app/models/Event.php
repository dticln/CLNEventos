<?php
namespace App\Models;
use Pure\Bases\Model;

/**
 * Representa um evento na camada de Modelagem,
 * ou seu repositório
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class Event extends Model
{
	public $name;
	public $category;
	public $place;
	public $description;
	public $owner;
	public $last_updater;
	public $starts_at;
	public $ends_at;
	public $updated;
	public $created;

	public static function find_all_informations()
	{
		return Event::select(['event.*','usr.name user','ctg.name category_name', 'ctg.basecolor color'])
			->join('user usr')
			->on('event.owner = usr.id')
			->join('category ctg')
			->on('event.category = ctg.id')
			->execute();
	}
}