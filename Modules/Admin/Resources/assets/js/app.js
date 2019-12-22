window._ = require('lodash');
window.Dropzone = require('dropzone');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    //Ajax setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    require('bootstrap');
    require('admin-lte/plugins/bootstrap-switch/js/bootstrap-switch');
    require('admin-lte');
    require('admin-lte/plugins/select2/js/select2.full.js');
    require('jquery-slimscroll');
    require('datatables.net');          //DataTables Script
    require('datatables.net-bs4');       //DataTables Bootstrap Script
    require('jquery-slimscroll');
    window.ClassicEditor = require ('@ckeditor/ckeditor5-build-classic');
    require('air-datepicker');

} catch (e) {
    console.log(e);
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
window.toast                = require('./notifications');

window.copyToClipboard      = function (text) {
    let textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);
}

window.Vue = require('vue');
Vue.component('vue-select', require('./components/VueSelect.vue').default);

const app = new Vue({
    el: '#app',
    data: {

    }
});