<?php
namespace App\Views\Pages;
use Pure\Utils\Res;
?>

<div class="modal fade" id="dashboard-modal" tabindex="-1" role="dialog" aria-labelledby="dashboard-modal-label">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content reverse-background">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="dashboard-modal-label">Modal title</h4>
			</div>
			<div class="modal-body" id="dashboard-modal-body">
				...
			</div>
			<div class="modal-footer" id="dashboard-modal-footer">
				<button type="button" class="btn btn-default" id="dashboard-modal-cancel" data-dismiss="modal">
					<?= Res::str('cancel') ?>
				</button>
				<button type="button" class="" id="dashboard-modal-confirm">
					<?= Res::str('save') ?>
				</button>
			</div>
		</div>
	</div>
</div>