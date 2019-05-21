<?php
namespace App\Views\Pages;
?>

<?= $this->render_component('modal'); ?>
<?= $this->render_component('feedback'); ?>

<div class="row content-row">
	<div class="col-md-2">
		<button type="button" class="btn btn-custom tab-event" style="margin-bottom: 10px" aria-label="Atualizar p�gina de eventos">
			<span class="glyphicon glyphicon-refresh"></span>
		</button>
		<button type="button" class="btn btn-custom btn-event-insert" style="margin-bottom: 10px" aria-label="Adicionar um novo evento">
			<span class="glyphicon glyphicon-plus"></span>
		</button>
	</div>
	<div class="col-md-10">
		<div class="input-group">
			<input type="text" class="form-control"
				id="event-name-search"
				name="event-name-search"
				placeholder="Digite o nome do evento. Exemplo: Campus Aberto 2020" />
			<div class="input-group-addon input-group-addon-custom event-name-search-btn" 
				tabindex="0" 
				aria-label="Realizar pesquisa de evento"> Pesquisar </div>
		</div>
	</div>
</div>

<div class="row content-row">
	<div class="col-md-12">
		<div class="jumbotron reverse-background">
			<?php if($is_moderator): ?>
				<div class="alert alert-info alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Voc� possui permiss�o de moderador:</strong> voc� pode cadastrar,
					visualizar, editar e exclu�r eventos cadastrados por voc� e por outros usu�rios.
				</div>
			<?php else: ?>
				<div class="alert alert-info alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Ol�!</strong> Aqui voc� pode cadastrar novos eventos ou editar e exclu�r os seus eventos cadastrados.
				</div>
			<?php endif; ?>
			<?= $this->render_component('loading'); ?>
			<div class="content-event">

			</div>
		</div>
	</div>
</div>
