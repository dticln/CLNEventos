<?php
namespace App\Views\Components\Javascripts;
use Pure\Utils\DynamicHtml;
?>

<script defer="defer" src="//barra.brasil.gov.br/barra.js" type="text/javascript"></script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<?php if(PURE_ENV === 'production'): ?>
	<?= DynamicHtml::link_script('bootstrap.min.js') ?>
	<?= DynamicHtml::link_script('bootstrap-select/bootstrap-select.min.js') ?>
<?php else: ?>
	<?= DynamicHtml::link_script('bootstrap.min.js') ?>
	<?= DynamicHtml::link_script('bootstrap-select/bootstrap-select.min.js') ?>
<?php endif; ?>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->