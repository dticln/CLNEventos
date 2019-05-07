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

$('body').on('click', '.btn-event-edit', function () {
    $(MODAL_NAME + '-confirm').attr('disabled', false);
    loadForm('event/ajax_update/' + $(this).attr('id'), {
        title: 'Editar Evento',
        button: 'Atualizar',
        buttonClass: 'btn btn-primary',
        buttonAction: function () {
            $('#update-event .submit').click();
        }
    });
});

$('body').on('submit', '#update-event', function (event) {
    sendForm('event/ajax_update', $(this), 'event/ajax_list', '.content-event', event);
});

$('body').on('click', '.btn-event-delete', function () {
    loadForm('event/ajax_delete/' + $(this).attr('id'), {
        title: 'Excluir artigo',
        button: 'Excluir',
        buttonClass: 'btn btn-danger',
        buttonAction: function () {
            $('#delete-event .submit').click();
        }
    });
});

$('body').on('submit', '#delete-event', function (event) {
    sendForm('event/ajax_delete', $(this), 'event/ajax_list', '.content-event', event);
});