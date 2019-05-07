<?php
namespace App\Views\Pages\Ajax\Event;
use App\Utils\Helpers;
?>


<?php if(empty($events)):  ?>
	<div class="alert alert-danger">
		<?= Res::str('no_events') ?>
	</div>
<?php endif; ?>

<?php foreach($events as $event): ?>
	<div id="accordion" class="panel-group" role="tablist" aria-multiselectable="true">
		<!-- Início da área de Cabeçalho do Evento -->
		<div class="panel-heading" role="tab" 
			id="heading-event-<?= $event->id ?>" 
			style="background-color: <?= $event->color ?>">
			<div class="panel-title">
				<a class="collapsed" role="button" 
					data-toggle="collapse" 
					data-parent="#accordion" 
					href="#collapse-event-<?= $event->id ?>" 
					aria-expanded="false" 
					aria-controls="collapse-event-<?= $event->id ?>" 
					aria-label="Ver detalhes do evento <?= $event->name ?>">
					<span class="event-name" id="<?= $event->id ?>">
						<?= $event->name ?>
					</span>
				</a>
				<small>
					<?= $event->category_name ?>
				</small>
				<span style="float:right">
					<span class="icon glyphicon glyphicon-time"></span>
					<span class="icon" tabindex="0">
						<?= Helpers::interval_format($event->starts_at, $event->ends_at) ?>
					</span>
					<span class="icon glyphicon glyphicon-pencil btn-event-edit" 
						id="<?= $event->id ?>" 
						tabindex="0" 
						aria-label="Editar o evento <?= $event->name ?>"></span>
					<span class="icon glyphicon glyphicon-trash btn-event-delete" 
						id="<?= $event->id ?>" 
						tabindex="0" 
						aria-label="Excluir o evento <?= $event->name ?>"></span>
				</span>
			</div>
		</div>
		<!-- Término da área de Cabeçalho do Evento -->

		<!-- Início da área de Corpo do Evento -->
		<div id="collapse-event-<?= $event->id ?>" 
			class="panel-collapse collapse" 
			role="tabpanel" 
			aria-labelledby="heading-art-<?= $event->id ?>">
			<div class="panel-body">
				<p class="category-infos">
					<small>
						<span aria-label="Localização do Evento" tabindex="0">
							<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
							<?= $event->place ?>
						</span>
					</small>
				</p>
				<hr />
				<div class="container" tabindex="0">
					<?= $event->description ?>
				</div>
			</div>
		</div>
		<!-- Final da área de Corpo do Evento -->
	</div>
<?php endforeach; ?>