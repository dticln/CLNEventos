<?php
namespace App\Views\Pages;
use App\Utils\Helpers;
?>

<?= $this->render_component('modal'); ?>
<?= $this->render_component('feedback'); ?>

<div class="row content-row">
	<div class="col-md-2">
		<button type="button" class="btn btn-custom btn-event-insert" style="margin-bottom: 10px" aria-label="Adicionar um novo evento">
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
			<?= $this->render_component('loading'); ?>
			<div class="content-event">

			</div>
		</div>
	</div>
</div>
