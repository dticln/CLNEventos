<?php
namespace App\Views\Pages;
use App\Utils\Helpers;
?>

<div class="row content-row">
	<div class="col-md-2">
		<button type="button" class="btn btn-custom" style="margin-bottom: 10px" aria-label="Adicionar um novo evento">
			<span class="glyphicon glyphicon-plus"></span>
		</button>
	</div>
	<div class="col-md-10">
		<div class="input-group">
			<input type="text" class="form-control" id="" placeholder="Digite o nome do evento. Exemplo: Campus Aberto 2020" />
			<div class="input-group-addon input-group-addon-custom" tabindex="0" aria-label="Realizar pesquisa de evento"> Pesquisar </div>
		</div>
	</div>
</div>

<div class="row content-row">
	<div class="col-md-12">
		<div class="jumbotron reverse-background">
			<?php foreach($events as $event): ?>
			<div id="accordion" class="panel-group" role="tablist" aria-multiselectable="true">
				<div class="panel-heading" role="tab" id="heading-event-<?= $event->id ?>" style="background-color: <?= $event->color ?>">
					<div class="panel-title">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-event-<?= $event->id ?>" aria-expanded="false" aria-controls="collapse-event-<?= $event->id ?>" aria-label="Ver detalhes do evento <?= $event->name ?>">
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
							<span class="icon glyphicon glyphicon-pencil btn-event-edit" id="<?= $event->id ?>" tabindex="0" aria-label="Editar o evento <?= $event->name ?>"></span>
							<span class="icon glyphicon glyphicon-trash btn-event-delete" id="<?= $event->id ?>" tabindex="0" aria-label="Excluir o evento <?= $event->name ?>"></span>
						</span>
					</div>
				</div>
				<div id="collapse-event-<?= $event->id ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-art-<?= $event->id ?>">
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
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
