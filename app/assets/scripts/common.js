/**
 * Variaveis padrões utilizadas pelo projeto
 */
var GET_URL = window.location;
var PATH_NAME = GET_URL.pathname.split('/');
var BASE_URL = GET_URL.protocol + '//' + GET_URL.host + '/' + PATH_NAME[1] + '/';
var DEV_ENV = (BASE_URL.includes('localhost')) ? true : false;

var LOADING_IMAGE = '<img class=\"loading-icon\" src=\"' + BASE_URL + 'app/assets/images/loading_icon.gif\">';
var ERROR_MESSAGE = '<p>Há um problema com sua conexão com a internet, tente novamente mais tarde.</p>';
var ADD_USER_MESSAGE = '<div class="modal-body" id="feedback-modal-body"><h4>Ops!</h4><p>O cartão UFRGS deve ser composto por número e ter de 0 a 8 caracteres.</p></div>';
var SEARCH_MESSAGE = '<div class="modal-body" id="feedback-modal-body"><h4>Ops!</h4><p>Para pesquisar, insira um nome válido.</p></div>';
var MODAL_NAME = '#dashboard-modal';

/**
 * Carrega determinado formulário solicitado por Ajax
 * Permite a edição de configurações do modal, entre eles o título,
 * o texto do botão, a classe css do botão e a ação executada por esse botão.
 *
 * @param {string} receiveFrom rota que envia os dados internos do modal
 * @param {Object} modalInformation dados personalizados do modal
 * @default modalInformation {
 *  title: '',
 *  button: 'Confirmar',
 *  buttonClass: 'btn btn-primary',
 *  buttonAction: function () { }
 * }
 *
 */
function loadForm(recieveFrom, modalInformation) {
    if (modalInformation === undefined) {
        modalInformation = {
            title: '',
            button: 'Confirmar',
            buttonClass: 'btn btn-primary',
            buttonAction: function () { }
        };
    }
    $.ajax({
        type: 'GET',
        url: BASE_URL + recieveFrom
    }).done(function (result, code) {
        if (code === 'success') {
            bindModal(
                modalInformation.title,
                result,
                modalInformation.button,
                modalInformation.buttonClass,
                modalInformation.buttonAction
            );
            showModal();
        } else {
            showMessage(ERROR_MESSAGE);
        }
    }).fail(function (result) {
        showMessage(ERROR_MESSAGE);
    });
}

/**
 * Função de envio de formulário via Ajax.
 * Realiza um envio de formumário {form} serializado,
 * para uma determinada rota {sendTo}
 * e recarrega o conteúdo de um container {contentTarget}
 * com base em uma outra url {contentSource}
 *
 * @param {string} sendTo rota a qual será enviada a requisição
 * @param {Object} form formulário que será enviado
 * @param {string} contentSource recarrega conteúdo: rota da qual virá o conteúdo
 * @param {string} contentTarget recarrega conteúdo: alvo que receberá o conteúdo
 * @param {event} event evento de click que receberá o preventDefault()
 */
function sendForm(sendTo, form, contentSource, contentTarget, event) {
    event.preventDefault();
    hideModal();
    var data = form.serialize();
    $(this).unbind();
    $.ajax({
        type: 'POST',
        url: BASE_URL + sendTo,
        data: data
    }).done(function (response, code) {
        if (code === 'success') {
            loadContent(contentSource, contentTarget);
        } else {
            response = ERROR_MESSAGE;
        }
        showMessage(response);
    }).fail(function (response, code) {
        showMessage(ERROR_MESSAGE);
    });
}

function sendFileForm(sendTo, form, filename, contentSource, contentTarget, event) {
    event.preventDefault();
    hideModal();
    var data = new FormData(form.context);
    $(this).unbind();
    $.ajax({
        type: 'POST',
        url: BASE_URL + sendTo,
        data: data,
        cache: false,
        contentType: false,
        processData: false
    }).done(function (response, code) {
        if (code === 'success') {
            loadContent(contentSource, contentTarget);
        } else {
            response = ERROR_MESSAGE;
        }
        showMessage(response);
    }).fail(function (response, code) {
        showMessage(ERROR_MESSAGE);
    });
}


/**
 * Carrega conteúdo de uma requisição ajax para um elemento HTML.
 *
 * @param {string} route rota da requisição
 * @param {string} target elemento HTML alvo
 */
function loadContent(route, target) {
    showLoading(target);
    $.ajax({
        type: 'GET',
        url: BASE_URL + route,
    }).done(function (result, code) {
        hideLoading(target);
        if (code === 'success') {
            $(target).html(result);
        } else {
            $(target).html(ERROR_MESSAGE);
        }
    }).fail(function (result) {
        hideLoading(target);
        $(target).html(ERROR_MESSAGE);
    });
}

/**
 * Função de evento de verificação de determinada checkbox para mostrar ou esconder determinada div.
 * Permite envio de callbacks para realização de eventos ao mostrar ou esconder conteúdo vinculado a checkbox.
 *
 * @param {any} target div que será modificada
 * @param {any} checkbox checkbox que será verificada na função
 * @param {function} doDisabled função que será executada caso a checkbox seja desmarcada
 * @param {function} doEnabled função que será executada caso a checkbox seja marcada
 */
function collapseCheckbox(target, checkbox, doDisabled, doEnabled) {
    if (doDisabled === undefined) { doDisabled = function () { }; }
    if (doEnabled === undefined) { doEnabled = function () { }; }
    if (checkbox.is(':checked')) {
        $(target).removeClass('hide');
        doDisabled();
    } else {
        $(target).addClass('hide');
        doEnabled();
    }
}

/**
 * Encapsula a tag <img> com a imagem de carregamento dentro de um elemento HTML
 * @param {string} tag elemento HTML 
*/
function useLoadingImage(tag) {
    $(tag).html(LOADING_IMAGE);
}


/**
 * Define os valores para o modal principal do dashboard
 *
 * @param {string} label titulo do modal
 * @param {string} content conteúdo HTML interno do modal
 * @param {string} buttonText texto do botão de confirmação
 * @param {string} buttonClass classe CSS do botão de confirmação
 * @param {function} buttonEvent função executada pelo botão de confirmação
 */
function bindModal(label, content, buttonText, buttonClass, buttonEvent) {
    $(MODAL_NAME + '-label').html(label);
    $(MODAL_NAME + '-body').html(content);
    $(MODAL_NAME + '-confirm').text(buttonText);
    $(MODAL_NAME + '-confirm').attr('class', buttonClass);
    $(MODAL_NAME + '-confirm').off('click');
    $(MODAL_NAME + '-confirm').click(buttonEvent);
}

/**
 * Mostra o modal na tela
 */
function showModal() {
    $(MODAL_NAME).modal('show');
}

/**
 * Fecha o modal na tela
 */
function hideModal() {
    $(MODAL_NAME).modal('hide');
}

/**
 * Mostra um modal com uma mensagem de feedback para o usuário
 * @param {string} message mensagem que será mostrada
 */
function showMessage(message) {
    $('#feedback-modal-content').html(message);
    $('#feedback-modal').modal('show');
}

/**
 * Mostra barra de "carregando" na tela, enquanto esconde determinado modal {target}
 * @param {string} target
 */
function showLoading(target) {
    $('.loading').show(800);
    $(target).hide(800);
}

/**
 * Esconde barra de "carregando" na tela, enquanto mostra determinado modal {target}
 * @param {string} target
 */
function hideLoading(target) {
    $('.loading').hide(800);
    $(target).show(800);
}