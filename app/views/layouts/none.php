<?php
namespace App\Views\Layout;
?>

<!DOCTYPE html>
<html lang="pt-br">
<?= $this->render_component('heads/minimal'); ?>
<body class="reverse-background">
	<?= $this->content(); ?>
	<?= $this->render_component('javascripts/default'); ?>
</body>
</html>