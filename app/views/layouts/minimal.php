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
				<a href="<?= DynamicHtml::link_to('site/index') ?>">
					<?= DynamicHtml::img('logo_cln.png', ['class' => 'logo','alt' => 'UFRGS']) ?>
				</a>
				<h1>
					<?= Res::str('app_title_short'); ?>
					<span>
						<?= Res::str('name_cpd_cln'); ?>
					</span>
				</h1>
			</div>
		</div>
	</div>
	<?= $this->content(); ?>
	<?= $this->render_component('javascripts/default'); ?>
</body>
</html>