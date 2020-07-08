import vuetify from './vuetify/vuetify' // path to vuetify export


require('./bootstrap');


window.Vue = require('vue');

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Program calendar component
Vue.component('calendar', require('./components/Calendar.vue').default);

// Load Vue.js
const app = new Vue({
    vuetify,
    el: '#app',
});
