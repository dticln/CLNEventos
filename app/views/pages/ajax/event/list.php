<?php
namespace App\Views\Pages\Ajax\Event;
use App\Utils\Helpers;
use Pure\Utils\Res;
?>

<?php if($search): ?>
<div class="alert alert-info">
	<?= Res::str('search_for') ?> "<span class="event-current-search"><?= $search ?></span>".
	<small style="font-size: 10px">
		<?= Res::str('search_w') ?> <?= $count ?> <?= Res::str('search_w_event') ?>
	</small>
</div>
<?php endif; ?>

<?php if(empty($events)):  ?>
	<div class="alert alert-danger">
		<?= Res::str('no_events') ?>
	</div>
<?php endif; ?>

<?php foreach($events as $event): ?>
	<div id="accordion" class="panel-group" role="tablist" aria-multiselectable="true">
		<!-- Início da área de Cabeçalho do Evento -->
		<div class="panel-heading" role="tab"
			<?= $event->finished ? 'style="background-color: #606060"' : '' ?>
			id="heading-event-<?= $event->id ?>">
			<div class="panel-title">
				<a class="collapsed" role="button"
					data-toggle="collapse"
					data-parent="#accordion"
					href="#collapse-event-<?= $event->id ?>"
					aria-expanded="false"
					aria-controls="collapse-event-<?= $event->id ?>"
					aria-label="
						<?= $event->finished ? 
							'Ver detalhes do evento encerrado' : 
							'Ver detalhes do evento ' ?> 
						<?= $event->name ?>">
					<span class="event-name" id="<?= $event->id ?>">
						<?= Helpers::str_limit($event->name, 25) ?>
					</span>
				</a>
				<!-- Início para área de informações para grandes resoluções -->
				<span style="float:right" class="visible-lg">
					<small class="badge" style="background-color: <?= $event->color ?>">
						<?= $event->category_name ?>
						<span class="glyphicon glyphicon-tags"
							aria-hidden="true"></span>
					</small>
					<span class="icon glyphicon glyphicon-time"></span>
					<span class="icon" tabindex="0">
						<?= Helpers::interval_format($event->starts_at, $event->ends_at) ?> 
					</span>
					<?php if(!$event->finished || $is_moderator): ?>
						<span class="icon glyphicon glyphicon-pencil btn-event-edit"
							id="<?= $event->id ?>"
							tabindex="0"
							aria-label="Editar o evento <?= $event->name ?>"></span>
						<span class="icon glyphicon glyphicon-trash btn-event-delete"
							id="<?= $event->id ?>"
							tabindex="0"
							aria-label="Excluir o evento <?= $event->name ?>"></span>
					<?php else: ?>
						<small class="badge" style="background-color: #707070; color: white;">
							Encerrado
							<span class="glyphicon glyphicon-info-sign"
								aria-hidden="true"></span>
						</small>
					<?php endif ?>
				</span>
				<!-- Término para área de informações para grandes resoluções -->
				<!-- Início para área de informações para resolução média -->
				<span class="visible-md">
					<small style="display: inline-block">
						<span class="icon glyphicon glyphicon-time"></span>
						<span class="icon" tabindex="0">
							<?= Helpers::interval_format($event->starts_at, $event->ends_at) ?>
						</span>
					</small>
					<span style="float:right;">
						<?php if(!$event->finished || $is_moderator): ?>
							<span class="icon glyphicon glyphicon-pencil btn-event-edit"
								id="<?= $event->id ?>"
								tabindex="0"
								aria-label="Editar o evento <?= $event->name ?>"></span>
							<span class="icon glyphicon glyphicon-trash btn-event-delete"
								id="<?= $event->id ?>"
								tabindex="0"
								aria-label="Excluir o evento <?= $event->name ?>"></span>
						<?php else: ?>
							<small class="badge" style="background-color: #707070; color: white;">
								Encerrado
								<span class="glyphicon glyphicon-info-sign"
									aria-hidden="true"></span>
							</small>
						<?php endif ?>
					</span>
				</span>
				<!-- Término para área de informações para resolução média -->
				<!-- Início para área de informações para celulares -->
				<span class="visible-sm visible-xs">
					<small style="display: inline-block">
						<span class="icon glyphicon glyphicon-time"></span>
						<span class="icon" tabindex="0">
							<?= Helpers::interval_format($event->starts_at, $event->ends_at) ?>
						</span>
					</small>
					<span style="margin-top: 20px;">
						<?php if(!$event->finished || $is_moderator): ?>
						<span class="icon glyphicon glyphicon-pencil btn-event-edit"
							id="<?= $event->id ?>"
							tabindex="0"
							aria-label="Editar o evento <?= $event->name ?>"></span>
						<span class="icon glyphicon glyphicon-trash btn-event-delete"
							id="<?= $event->id ?>"
							tabindex="0"
							aria-label="Excluir o evento <?= $event->name ?>"></span>
						<?php else: ?>
						<small class="badge" style="background-color: #707070; color: white;">
							Encerrado
							<span class="glyphicon glyphicon-info-sign"
								aria-hidden="true"></span>
						</small>
						<?php endif ?>
					</span>
				</span>
				<!-- Término para área de informações para celulares -->
			</div>
		</div>
		<!-- Término da área de Cabeçalho do Evento -->

		<!-- Início da área de Corpo do Evento -->
		<div id="collapse-event-<?= $event->id ?>" 
			class="panel-collapse collapse" 
			role="tabpanel" 
			aria-labelledby="heading-art-<?= $event->id ?>">
			<div class="panel-body">
				<p>
					<small>
						<span aria-label="Localização do Evento" tabindex="0" class="panel-head-content">
							<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
							<?= $event->place ?>
						</span>
						<?php if($is_moderator): ?>
							<span aria-label="Usuário que cadastrou o Evento" tabindex="0" class="panel-head-content">
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
								<?= $event->user ?>
							</span>
						<?php endif; ?>
					</small>
				</p>
				<hr />
				<div class="container content" tabindex="0">
					<?= $event->description ?>
				</div>
			</div>
		</div>
		<!-- Final da área de Corpo do Evento -->
	</div>
<?php endforeach; ?>

<?php if(!empty($events)):  ?>
	<div class="text-center event-pagination">
		<?= Helpers::pagination($per_page, $count, ($page) ? $page : 1) ?>
	</div>
<?php endif; ?>
