<?php
namespace App\Views\Pages\Ajax\Event;
use Pure\Utils\DynamicHtml;
use Pure\Utils\Res;
use App\Utils\Helpers;
?>

<?=DynamicHtml::link_script('ckeditor/ckeditor.js'); ?>

<form id="update-event">
	<div class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
		<!-- Início do campo Nome do Evento -->
		<div class="form-group">
			<label for="update-event-name"><?= Res::str('event_name') ?></label>
			<input type="text" class="form-control" 
				id="update-event-name" 
				name="update-event-name" 
				aria-label="<?= Res::str('event_name_al') ?>" 
				placeholder="<?= Res::str('event_name_ph') ?>"
				value="<?= $event->name ?>"
				maxlength="45" required />
		</div>
		<!-- Final do campo Nome do Evento -->
		
		<!-- Início do campo Local do Evento -->
		<div class="form-group">
			<label for="update-event-place"><?= Res::str('event_place') ?></label>
			<input type="text" class="form-control" 
				id="update-event-place" 
				name="update-event-place" 
				aria-label="<?= Res::str('event_place_al') ?>" 
				placeholder="<?= Res::str('event_place_ph') ?>" 
				value="<?= $event->place ?>"
				maxlength="45" required />
		</div>
		<!-- Final do campo Local do Evento -->
		
		<!-- Início do campo Categoria do Evento -->
		<div class="form-group" id="event-category-form">
			<label for="event-category"><?= Res::str('event_cat_src') ?> </label>
			<select class="form-control" 
				data-live-search="true" 
				id="update-event-category" 
				name="update-event-category" required>
				<?php foreach($categories as $category): ?>
					<?php if($category->id == $event->category): ?>
						<option value="<?= $category->id ?>" selected> <?= $category->name ?> </option>
					<?php else: ?>
						<option value="<?= $category->id ?>"> <?= $category->name ?> </option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
		</div>
		<!-- Final do campo Categoria do Evento -->
	</div>
	
	<!-- Início do campo Data de Início do Evento -->
	<div class='col-sm-6' style="padding-left: 0px !important;">
		<div class="form-group">
			<label for="event-body"> <?= Res::str('event_star_date') ?></label>
			<div class='input-group date' id='update-event-start'>
				<input type='text' name="update-event-start" 
					class="form-control" 
					aria-label="<?= Res::str('event_star_date_al') ?>" 
					value="<?= Helpers::date_format($event->starts_at) ?>"
					placeholder="<?= Res::str('event_star_date_ph') ?>" required/>
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
		</div>
		<script type="text/javascript">
			$(function () {
				$('#update-event-start').datetimepicker({
					locale: 'pt-br'
				});
			});
		</script>
	</div>
	<!-- Final do campo Data de Início do Evento -->

	<!-- Início do campo Data de Término do Evento -->
	<div class='col-sm-6' style="padding-right: 0px !important;">
		<div class="form-group">
			<label for="event-body"> <?= Res::str('event_end_date') ?></label>
			<div class='input-group date' id='update-event-end'>
				<input type='text' name="update-event-end" 
					class="form-control" 
					aria-label="<?= Res::str('event_end_date_al') ?>" 
					value="<?=  Helpers::date_format($event->ends_at) ?>"
					placeholder="<?= Res::str('event_end_date_ph') ?>" required/>
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
		</div>
		<script type="text/javascript">
			$(function () {
				$('#update-event-end').datetimepicker({
					locale: 'pt-br'
				});
			});
		</script>
	</div>
	<!-- Final do campo Data de Término do Evento -->
	
	<!-- Início do campo Descrição do Evento -->
	<div class="form-group">
		<label for="update-event-body"> <?= Res::str('event_body_label') ?></label>
		<textarea name="update-event-body" 
			id="update-event-body" 
			rows="10" cols="80" required>
			<?= $event->description ?>
		</textarea>
		<script>
        	CKEDITOR.replace('update-event-body');
		</script>
	</div>
	<!-- Final do campo Descrição do Evento -->
	
	<!-- Início do campo Id do Evento -->
	<input type="text" class="submit" 
		name="update-event-id" 
		value="<?= $event->id ?>" 
		readonly style="display:none;" />
	<!-- Final do campo Id do Evento -->

	<input type="submit" class="submit" style="display:none;">
</form>