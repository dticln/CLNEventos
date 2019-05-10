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
		<div class="row text-center">
			<div class="col-md-6 col-md-offset-3 header">
				<h1>
					<?= Res::str('app_title_short'); ?>
				</h1>
				<span>
					<?= Res::str('name_cpd_cln'); ?>
				</span>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="content-row">
			<?= $this->content(); ?>
		</div>
	</div>
	<?= $this->render_component('javascripts/default'); ?>
</body>
</html>