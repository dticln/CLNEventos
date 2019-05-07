<?php
namespace App\Views\Pages\Ajax;
?>

<?php if(isset($modal) && $modal == true): ?>
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4>
			<?= $title; ?>
		</h4>
	</div>
	<div class="modal-body" id="feedback-modal-body">
	<p>
		<?= $body; ?>
	</p>
</div>
<?php else: ?>
	<div>
		<h4>
			<?= $title; ?>
		</h4>
		<p>
			<?= $body; ?>
		</p>
	</div>
<?php endif; ?>


