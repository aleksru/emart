
window.iziToast = require('izitoast');


/**
 * Настройки iziToast для всплывающего и модального сообщения.
 * 
 * @type {{notification: {maxWidth: number, layout: number, position: string, theme: string, transitionIn: string, transitionOut: string, transitionInMobile: string, transitionOutMobile: string}, modal: {layout: number, timeout: boolean, overlay: boolean, close: boolean, overlayClose: boolean, position: string, maxWidth: number, transitionIn: string, transitionOut: string, transitionInMobile: string, transitionOutMobile: string}}}
 */
const settings = {
    notification: {
        position: 'topRight',
        transitionIn: 'fadeInLeft',
        maxWidth: 400,
    },
    
    modal: {
        layout: 2,
        timeout: false,
        overlay: true,
        close: true,
        overlayClose: true,
        position: 'center',
        maxWidth: 450,
        transitionIn: 'bounceInDown',
        transitionOut: 'fadeOutUp',
        transitionInMobile: 'fadeInUp',
        transitionOutMobile: 'fadeOutDown',
        animateInside: true,
    }
}

module.exports = {

    /**
     * Выводит успешное сообщение. 
     * 
     * @param message
     * @param options
     * @returns {string}
     */
    success(message, options = { }) {
        let id = options.id || 'toast-' + (new Date().getUTCMilliseconds());
        iziToast.success({
            id: id,
            title: options.title || 'Успех!',
            message: message || 'Успех!',
            timeout: options.timeout || 4000,
            ...settings.notification
        });
        return id;
    },

    /**
     * Выводит сообщение ошибки.
     *
     * @param message
     * @param options
     * @returns {string}
     */
    error(message, options = { }) {
        let id = options.id || 'toast-' + (new Date().getUTCMilliseconds());
        iziToast.error({
            id: id,
            title: options.title || 'Ошибка!',
            message: message,
            timeout: options.timeout || 4000,
            ...settings.notification
        });
        return id;
    },

    /**
     * Выводит сообщение предупреждения.
     *
     * @param message
     * @param options
     * @returns {string}
     */
    warning(message, options = { }) {
        let id = options.id || 'toast-' + (new Date().getUTCMilliseconds());
        iziToast.warning(Object.assign(settings[options.type || 'notification'], {
            id: id,
            title: options.title || 'Предупреждение!',
            message: message,
            timeout: options.timeout || 4000,
            ...settings.notification
        }));
        return id;
    },

    /**
     * Выводит информационное сообщение.
     *
     * @param message
     * @param options
     * @returns {string}
     */
    info(message, options = { }) {
        let id = options.id || 'toast-' + (new Date().getUTCMilliseconds());
        iziToast.info({
            id: id,
            title: options.title || 'Внимание!',
            message: message,
            timeout: options.timeout || 4000,
            ...settings.notification
        });
        return id;
    },

    /**
     * Выводит сообщение загрузки.
     *
     * @param message
     * @param options
     * @returns {string}
     */
    loading(message, options = { }) {
        let id = options.id || 'toast-' + (new Date().getUTCMilliseconds());
        iziToast.warning({
            id: id,
            title: options.title || 'Загрузка...',
            message: message,
            timeout: options.timeout || false,
            icon: 'fa fa-spinner fa-spin',
            animateInside: false,
            ...settings.notification
        });
        return id;
    },

    /**
     * Выводит диалоговое окно подтверждения. 
     *
     * @param message
     * @param confirm
     * @param cancel
     * @param options
     * @returns {string}
     */
    confirm(message, confirm, cancel, options = { }) {
        let id = options.id || 'toast-' + (new Date().getUTCMilliseconds());
        iziToast.question({
            id: id,
            title: options.title || 'Внимание!',
            message: message,
            timeout: options.timeout || false,
            icon: 'fa fa-question',
            close: false,
            overlay: true,
            displayMode: 'once',
            zindex: 999,
            position: 'center',
            maxWidth: 450,
            buttons: [
                [`<button><b>Да</b></button>`, function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOutUp',
                        transitionOutMobile: 'fadeOutDown',
                    }, toast);
                    if (typeof confirm === 'function')
                        confirm();
                }],
                [`<button>Нет</button>`, function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOutUp',
                        transitionOutMobile: 'fadeOutDown',
                    }, toast);
                    if (cancel && typeof cancel === 'function')
                        cancel();
                }, true]
            ]
        });
        return id;
    },

    /**
     * Скрывает сообщение.
     * 
     * @param id
     * @returns {*}
     */
    hide(id) {
        if (!id)
            return null;
        let toast = document.querySelector(`#${id}`);
        if (toast) {
            iziToast.hide({
                transitionOut: 'fadeOutUp',
                transitionOutMobile: 'fadeOutDown',
            }, toast);
        }
        return true;
    },
};
