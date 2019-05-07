<?php
namespace App\Views\Pages\Ajax\Event;
use Pure\Utils\DynamicHtml;
use Pure\Utils\Res;
?>

<?=DynamicHtml::link_script('ckeditor/ckeditor.js'); ?>

<form id="new-event">

	<div class="col-md-12" style="padding-left: 0px !important; padding-right: 0px !important;">
		<!-- Início do campo Nome do Evento -->
		<div class="form-group">
			<label for="new-event-name"><?= Res::str('event_name') ?></label>
			<input type="text" class="form-control" id="new-event-name" name="new-event-name" aria-label="<?= Res::str('event_name_al') ?>" placeholder="<?= Res::str('event_name_ph') ?>" maxlength="45" required />
		</div>
		<!-- Final do campo Nome do Evento -->
		
		<!-- Início do campo Local do Evento -->
		<div class="form-group">
			<label for="new-event-place"><?= Res::str('event_place') ?></label>
			<input type="text" class="form-control" id="new-event-place" name="new-event-place" aria-label="<?= Res::str('event_place_al') ?>" placeholder="<?= Res::str('event_place_ph') ?>" maxlength="45" required />
		</div>
		<!-- Final do campo Local do Evento -->
		
		<!-- Início do campo Categoria do Evento -->
		<div class="form-group" id="event-category-form">
			<label for="event-category"><?= Res::str('event_cat_src') ?> </label>
			<select class="form-control" data-live-search="true" id="new-event-category" name="new-event-category" required>
				<option value=""><?= Res::str('event_cat_none') ?></option>
				<?php foreach($categories as $category): ?>
					<option value="<?= $category->id ?>"> <?= $category->name ?> </option>
				<?php endforeach; ?>
			</select>
		</div>
		<!-- Final do campo Categoria do Evento -->
	</div>
	
	<!-- Início do campo Data de Início do Evento -->
	<div class='col-sm-6' style="padding-left: 0px !important;">
		<div class="form-group">
			<label for="event-body"> <?= Res::str('event_star_date') ?></label>
			<div class='input-group date' id='new-event-start'>
				<input type='text' name="new-event-start" class="form-control" aria-label="<?= Res::str('event_star_date_al') ?>" placeholder="<?= Res::str('event_star_date_ph') ?>"/>
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
		</div>
		<script type="text/javascript">
			$(function () {
				$('#new-event-start').datetimepicker({
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
			<div class='input-group date' id='new-event-end'>
				<input type='text' name="new-event-end" class="form-control" aria-label="<?= Res::str('event_end_date_al') ?>" placeholder="<?= Res::str('event_end_date_ph') ?>"/>
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
		</div>
		<script type="text/javascript">
			$(function () {
				$('#new-event-end').datetimepicker({
					locale: 'pt-br'
				});
			});
		</script>
	</div
	<!-- Final do campo Data de Término do Evento -->
	
	<!-- Início do campo Descrição do Evento -->
	<div class="form-group">
		<label for="event-body"> <?= Res::str('event_body_label') ?></label>
		<textarea name="new-event-body" id="new-event-body" rows="10" cols="80" required>
			<?= Res::str('event_body_al') ?>
		</textarea>
		<script>
        	CKEDITOR.replace('new-event-body');
		</script>
	</div>
	<!-- Final do campo Descrição do Evento -->

	<input type="submit" class="submit" style="display:none;">
</form>