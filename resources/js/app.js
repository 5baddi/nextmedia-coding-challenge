require('./bootstrap')

import Vue from 'vue'
import Vuex from 'vuex'
import store from './services/store'
import { api } from './services/api'
import App from './app.vue'

// Set HTTP handler
Vue.prototype.$http = api

// Init app
const app = new Vue({
    el: '#app',
    components: { App },
    store
})
