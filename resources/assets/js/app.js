
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.initMap = () => {};

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('delete-button', require('./components/DeleteButton.vue'));
Vue.component('map-edit', require('./components/MapEdit.vue'));
Vue.component('direction-guide', require('./components/DirectionGuide.vue'));
Vue.component('map-view', require('./components/MapView.vue'));

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

window.bus = new Vue();
const app = new Vue({
    el: '#app'
});