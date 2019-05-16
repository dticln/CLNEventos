$(document).ready(function () {
    loadContent('event/ajax_list/', '.content-event');
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

$('body').on('click', '.event-pagination a', function (ev) {
    ev.preventDefault();
    var search = $('.event-current-search').html();
    var url = ((DEV_ENV) ? 'event/ajax_list&' : 'event/ajax_list/?');
    if (search !== undefined) {
        url += 'event-search=' + search + '&';
    }
    url += 'event-page=' + $(this).html();
    loadContent(url, '.content-event');
});

$('body').on('keypress', '#event-name-search', function (ev) {
    var search = $('#event-name-search').val();
    if (ev.which === 13) {
        ev.preventDefault();
        if (search.length > 0 && search.length < 200) {
            $(this).val('');
            var to = (DEV_ENV) ? 'event/ajax_list&event-search=' : 'event/ajax_list/?event-search=';
            loadContent(to + search, '.content-event');
        } else {
            showMessage(SEARCH_MESSAGE);
        }
    }
});

$('body').on('click', '.event-name-search-btn', function (ev) {
    var search = $('#event-name-search').val();
    ev.preventDefault();
    $('#event-name-search').val('');
    if (search.length > 0 && search.length < 200) {
        var to = (DEV_ENV) ? 'event/ajax_list&event-search=' : 'event/ajax_list/?event-search=';
        loadContent(to + search, '.content-event');
    } else {
        showMessage(SEARCH_MESSAGE);
    }
});

$('.tab-event').click(function () {
    loadContent('event/ajax_list', '.content-event');
});
