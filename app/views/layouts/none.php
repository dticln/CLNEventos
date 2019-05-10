<?php
namespace App\Views\Layout;
use Pure\Utils\DynamicHtml;
use Pure\Utils\Res;
?>

<!DOCTYPE html>
<html lang="en">
<?= $this->render_component('heads/minimal'); ?>
<body class="reverse-background">
	<?= $this->content(); ?>
	<?= $this->render_component('javascripts/default'); ?>
</body>
</html>