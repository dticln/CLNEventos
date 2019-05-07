<?php
namespace App\Views\Pages\Ajax\Event;
use Pure\Utils\Res;
?>

<form id="delete-event">
	<h4><?= Res::str('event_delete_question') ?></h4>
	<dl class="dl-horizontal">
		<dt><?= Res::str('event_name') ?>:</dt>
		<dd>
			<?= $event->name ?>
		</dd>
		<dt><?= Res::str('event_place') ?>:</dt>
		<dd>
			<?= $event->place ?>
		</dd>
		<dt><?= Res::str('event_star_date') ?>:</dt>
		<dd>
			<?= $event->starts_at ?>
		</dd>
		<dt><?= Res::str('event_end_date') ?>:</dt>
		<dd>
			<?= $event->ends_at ?>
		</dd>
	</dl>
	<input type="text" class="submit" name="event-id" value="<?= $event->id ?>" readonly style="display:none;" />
	<input type="submit" class="submit" style="display:none;" />
</form>