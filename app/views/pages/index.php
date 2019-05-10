<?php
namespace App\Views\Pages;
use App\Utils\Helpers;
?>

<?= Helpers::parse_to_js($rows, 'events') ?>
<?= $this->render_component('event_modal'); ?>

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function () {
		var calendarEl = document.getElementById('calendar');

		var calendar = new FullCalendar.Calendar(calendarEl, {
			customButtons: {
				config: {
					icon: 'cog',
					click: function () {
						window.open(BASE_URL + 'event/index', '_blank');
					}
				}
			},
			plugins: ['dayGrid', 'interaction'],
			defaultView: 'dayGridMonth',
			header: {
				left: 'dayGridWeek,dayGridMonth prev,next',
				center: 'title',
				right: 'today, config'
			},
			locale: 'pt-br',
			displayEventTime: false,
			events: BASE_URL + 'site/ajax_list',
			eventClick: function (info) {
				loadForm('site/ajax_event/' + info.event.id, {
					title: info.event.title,
					button: 'OK',
					buttonClass: 'btn btn-primary',
					buttonAction: function () {}
				});
			},
			eventMouseEnter: function (info) {
				info.el.style.borderColor = '#294A70';
				info.el.style.cursor = 'pointer';
			},
			eventMouseLeave: function (info) {
				info.el.style.borderColor = '';
				info.el.style.cursor = 'auto';
			},
			eventRender: function (info) {
				info.el.classList.add('event-item');
				info.el.setAttribute('tabindex', '0');
			}
		});

		calendar.render();
	});
</script>

<div class="jumbotron reverse-background">
	<div id="calendar"></div>
</div>