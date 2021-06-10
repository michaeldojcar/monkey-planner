import vuetify from './vuetify/vuetify'
import VueRouter from "vue-router";
import DashboardPage from "./components/dashboard/DashboardPage";
import ShowObjectPage from "./components/object/ShowObjectPage";
import SearchPage from "./components/search/SearchPage";
import Vuex from 'vuex'


require('./bootstrap');

require('./sb-admin/sb-admin-2.min')

window.Vue = require('vue');

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Program calendar component
Vue.component('app', require('./components/App.vue').default);
Vue.component('calendar', require('./components/Calendar.vue').default);
Vue.component('current-clock-widget', require('./components/CurrentClockWidget').default);

// Vue router
const routes = [
    {path: '/', component: DashboardPage},
    {path: '/search', component: SearchPage},
    {path: '/ob/:uuid', component: ShowObjectPage},
]

const router = new VueRouter({
    mode: 'history',
    base: '/spa',
    routes
})

Vue.use(Vuex)
Vue.use(VueRouter)

const store = new Vuex.Store({
    state: {
        searchQuery: null
    },
    mutations: {
        updateSearchQuery(state, query) {
            state.searchQuery = query
        }
    }
})

// Load Vue.js
const app = new Vue({
    store,
    router,
    vuetify,
    el: '#app',
});
