
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueGoogleMaps, {
    load: {
      key: "AIzaSyCe3LlAKdG4lCwkrulp3mzPL-K2o5UikMo",
      libraries: "places" // necessary for places input
    }
});

Vue.component('google-map-create-component', require('./components/GoogleMapCreate.vue'));
Vue.component('google-map-update-component', require('./components/GoogleMapUpdate.vue'));

const app = new Vue({
    el: '#app'
});
