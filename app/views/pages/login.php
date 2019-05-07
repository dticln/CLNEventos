<?php
namespace App\Views\Pages;
use Pure\Utils\DynamicHtml;
use Pure\Utils\Res;
use Pure\Utils\Params;
?>

<div class="container">
	<?php if($error_message):?>
	<div class="col-md-4 col-md-offset-4">
		<div class="alert alert-danger">
			<strong>
				<?= Res::str('ops') ?>
			</strong><?= $error_message; ?>
		</div>
	</div>
	<?php endif; ?>

	<form class="col-md-4 col-md-offset-4 login-form" action="<?= DynamicHtml::link_to('login/do&callback=' . Params::get_instance()->from_GET('callback')) ?>" method="POST">
		<label for="ufrgs_id" class="sr-only">
			<?= Res::str('usr_ufrgs_label') ?>
		</label>
		<input id="ufrgs_id" name="ufrgs_id" class="form-control" placeholder="<?= Res::str('usr_ufrgs_label') ?>" required="" autofocus="" />
		<label for="password" class="sr-only">
			<?= Res::str('password') ?>
		</label>
		<input id="password" name="password" class="form-control" placeholder="<?= Res::str('password') ?>" required="" type="password" />
		<br />
		<button class="btn btn-lg btn-primary btn-block" type="submit">
			<?= Res::str('login') ?>
		</button>
	</form>
	<div class="col-md-8 col-md-offset-2 header">
		<h1>
			<span>
				<?= Res::str('login_temp') ?>
			</span>
		</h1>
	</div>
</div>