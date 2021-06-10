import vuetify from './vuetify/vuetify' // path to vuetify export


require('./bootstrap');

require('./sb-admin/sb-admin-2.min')


window.Vue = require('vue');

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Program calendar component
Vue.component('app', require('./components/App.vue').default);
Vue.component('calendar', require('./components/Calendar.vue').default);
Vue.component('current-clock-widget', require('./components/CurrentClockWidget').default);

// Load Vue.js
const app = new Vue({
    vuetify,
    el: '#app',
});
