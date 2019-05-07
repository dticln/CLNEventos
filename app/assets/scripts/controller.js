$(document).ready(function () {
    loadContent('event/ajax_list', '.content-event');
});

$('body').on('click', '.btn-event-insert', function () {
    loadForm('event/ajax_insert', {
        title: 'Adicionar evento',
        button: 'Adicionar',
        buttonClass: 'btn btn-primary',
        buttonAction: function () {
            $('#new-event .submit').click();
        }
    });
});

$('body').on('submit', '#new-event', function (event) {
    sendForm('event/ajax_insert', $(this), 'event/ajax_list', '.content-event', event);
});