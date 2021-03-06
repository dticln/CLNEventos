<?php
namespace App\Views\Components\Heads;
use Pure\Utils\DynamicHtml;
use Pure\Utils\Res;
?>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<?= DynamicHtml::link_favicon('favicon.ico'); ?>
	<title> <?= Res::str('app_title') ?> </title>
	<!-- Bootstrap -->
	<?= DynamicHtml::link_css('bootstrap.min.css'); ?>
	<?php if(PURE_ENV === 'production'): ?>
		<?= DynamicHtml::link_css('ufrgs.min.css') ?>
		<?= DynamicHtml::link_css('minimal.min.css') ?>
		<?= DynamicHtml::link_css('bootstrap-datetimepicker/bootstrap-datetimepicker.min.css'); ?>
		<?= DynamicHtml::link_css('fullcalendar/core/main.min.css'); ?>
		<?= DynamicHtml::link_css('fullcalendar/daygrid/main.min.css'); ?>
		<?= DynamicHtml::link_css('fullcalendar/bootstrap/main.min.css'); ?>
	<?php else: ?>
		<?= DynamicHtml::link_css('ufrgs.css') ?>
		<?= DynamicHtml::link_css('minimal.css') ?>
		<?= DynamicHtml::link_css('bootstrap-datetimepicker/bootstrap-datetimepicker.css'); ?>
		<?= DynamicHtml::link_css('fullcalendar/core/main.css'); ?>
		<?= DynamicHtml::link_css('fullcalendar/daygrid/main.css'); ?>
		<?= DynamicHtml::link_css('fullcalendar/bootstrap/main.css'); ?>
	<?php endif; ?>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<meta property="creator.productor" content="http://estruturaorganizacional.dados.gov.br/id/unidade-organizacional/200000" />
</head>