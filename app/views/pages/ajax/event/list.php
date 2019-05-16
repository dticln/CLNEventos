<?php
namespace App\Views\Pages\Ajax\Event;
use App\Utils\Helpers;
use Pure\Utils\Res;
?>

<?php if($search): ?>
<div class="alert alert-info">
	<?= Res::str('search_for') ?> "<span class="article-current-search"><?= $search ?></span>".
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
		<!-- In�cio da �rea de Cabe�alho do Evento -->
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
				<!-- In�cio para �rea de informa��es para grandes resolu��es -->
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
					<?php if(!$event->finished): ?>
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
				<!-- T�rmino para �rea de informa��es para grandes resolu��es -->
				<!-- In�cio para �rea de informa��es para resolu��o m�dia -->
				<span class="visible-md">
					<small style="display: inline-block">
						<span class="icon glyphicon glyphicon-time"></span>
						<span class="icon" tabindex="0">
							<?= Helpers::interval_format($event->starts_at, $event->ends_at) ?>
						</span>
					</small>
					<span style="float:right;">
						<?php if(!$event->finished): ?>
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
				<!-- T�rmino para �rea de informa��es para resolu��o m�dia -->
				<!-- In�cio para �rea de informa��es para celulares -->
				<span class="visible-sm visible-xs">
					<small style="display: inline-block">
						<span class="icon glyphicon glyphicon-time"></span>
						<span class="icon" tabindex="0">
							<?= Helpers::interval_format($event->starts_at, $event->ends_at) ?>
						</span>
					</small>
					<span style="margin-top: 20px;">
						<?php if(!$event->finished): ?>
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
				<!-- T�rmino para �rea de informa��es para celulares -->
			</div>
		</div>
		<!-- T�rmino da �rea de Cabe�alho do Evento -->

		<!-- In�cio da �rea de Corpo do Evento -->
		<div id="collapse-event-<?= $event->id ?>" 
			class="panel-collapse collapse" 
			role="tabpanel" 
			aria-labelledby="heading-art-<?= $event->id ?>">
			<div class="panel-body">
				<p class="category-infos">
					<small>
						<span aria-label="Localiza��o do Evento" tabindex="0">
							<span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
							<?= $event->place ?>
						</span>
					</small>
				</p>
				<hr />
				<div class="container content" tabindex="0">
					<?= $event->description ?>
				</div>
			</div>
		</div>
		<!-- Final da �rea de Corpo do Evento -->
	</div>
<?php endforeach; ?>

<?php if(!empty($events)):  ?>
	<div class="text-center event-pagination">
		<?= Helpers::pagination($per_page, $count, ($page) ? $page : 1) ?>
	</div>
<?php endif; ?>
