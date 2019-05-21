<?php
namespace App\Views\Layout;
use Pure\Utils\DynamicHtml;
use Pure\Utils\Res;
?>

<!DOCTYPE html>
<html lang="en">
<?= $this->render_component('heads/minimal'); ?>
<body>
	<?= $this->render_component('govbar'); ?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1 class="header-title">Agendamento de Eventos</h1>
				<h2>Eventos cadastrados</h2>
			</div>
		</div>
		<?= $this->content(); ?>
	</div>
	<?= $this->render_component('javascripts/default'); ?>
	<?= $this->render_compoment('footer'); ?>
</body>
</html>