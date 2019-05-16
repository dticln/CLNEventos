<?php
namespace App\Models;
use Pure\Bases\Model;
use App\Utils\Helpers;

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
			->order_by(['event.ends_at' => 'DESC'])
			->execute();
	}

	public static function select_at_page($limit, $page)
	{
		$offset = ((intval($page) - 1) * intval($limit));
		return Event::select(['event.*','usr.name user','ctg.name category_name', 'ctg.basecolor color'])
			->join('user usr')
			->on('event.owner = usr.id')
			->join('category ctg')
			->on('event.category = ctg.id')
			->order_by(['event.ends_at' => 'DESC'])
			->limit($limit)
			->offset(intval($offset))
			->execute();
	}

	public static function select_at_page_where($where, $limit, $page)
	{
		$offset = ((intval($page) - 1) * intval($limit));
		return Event::select(['event.*','usr.name user','ctg.name category_name', 'ctg.basecolor color'])
			->join('user usr')
			->on('event.owner = usr.id')
			->join('category ctg')
			->on('event.category = ctg.id')
			->where_like(['event.name' => '%' . $where . '%'])
			->order_by(['event.ends_at' => 'DESC'])
			->limit($limit)
			->offset(intval($offset))
			->execute();
	}

	public static function select_count()
	{
		return self::select('COUNT(*) as count')
			->execute()[0]->count;
	}

	public static function select_count_where($where)
	{
		return self::select('COUNT(*) as count')
				->where_like(['name' => '%'.$where.'%'])
				->execute()[0]->count;
	}

	public static function get_events_at_interval($start, $end)
	{
		return Event::build(
			'SELECT ev.*, usr.name user, ctg.name category_name, ctg.basecolor color FROM event ev
				JOIN user usr
				ON ev.owner = usr.id
				JOIN category ctg
				ON ev.category = ctg.id
				WHERE
				(ev.starts_at > CAST(\'' . $start . '\' AS DATETIME) AND ev.ends_at < CAST(\'' . $end . '\' AS DATETIME)) OR
				(ev.ends_at > CAST(\'' . $start . '\' AS DATETIME) AND ev.starts_at < CAST(\'' . $start . '\' AS DATETIME)) OR
				(ev.starts_at < CAST(\'' . $end . '\' AS DATETIME) AND ev.ends_at > CAST(\'' . $end . '\' AS DATETIME))
				ORDER BY ev.ends_at DESC'
		)->execute();
	}

}