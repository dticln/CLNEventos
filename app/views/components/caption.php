<?php
namespace App\Views\Pages;
?>

<div class="container text-center" style="margin-top: 10px;">
	<?php foreach($categories as $category): ?>
	<small class="badge category-caption" style="background-color: <?= $category->basecolor ?>;">
		<?= $category->name ?>
	</small>
	<?php endforeach; ?>
</div>
