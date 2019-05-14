<?php
namespace App\Views\Pages\Ajax\Event;
use App\Utils\Helpers;
?>

<div>
	<h4 aria-label="Categoria do Evento" tabindex="0">
		<span class="glyphicon glyphicon-tags" aria-hidden="true" style="margin-right: 10px"> </span> 
		<?= $event->category ?>
	</h4>
	<h4 aria-label="Lugar do Evento" tabindex="0">
		<span class="glyphicon glyphicon-map-marker" aria-hidden="true" style="margin-right: 10px"></span>
		<?= $event->place ?>
	</h4>
	<h4 aria-label="Localização do Evento" tabindex="0">
		<span class="icon glyphicon glyphicon-time" aria-hidden="true" style="margin-right: 10px"></span>
		<?= Helpers::interval_format($event->starts_at, $event->ends_at) ?>
	</h4>
	<hr />
	<span tabindex="0">
		<?= $event->description ?>
	</span>
</div>