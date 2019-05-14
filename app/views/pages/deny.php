<?php
namespace App\Views\Pages;
use Pure\Utils\DynamicHtml;
use Pure\Utils\Res;
?>
<div class="container text-center">
	<div class="row">
		<div class="col-md-12">
			<div style="color: white;">
				<h1>
					<?= Res::str('ops') ?>
				</h1>
				<h2>
					<?= Res::str('404') ?>
				</h2>
				<h3>
					<?= Res::str('not_found') ?>
				</h3>
				<div style="margin: 15px;">
					<a href="<?= DynamicHtml::link_to('site/index') ?>" class="btn btn-primary btn-lg" style="margin: 10px;">
						<span class="glyphicon glyphicon-home"></span>
						<?= Res::str('leave_me') ?>
					</a>
					<a href="mailto:dti-cln@ufrgs.br" class="btn btn-default btn-lg">
						<span class="glyphicon glyphicon-envelope"></span>
						<?= Res::str('contact_us') ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>