
import './bootstrap';
import Vue from 'vue'
import './plugins'

window.Vue = Vue;

import router from './router'
import store from './store'

import App from './components/App.vue'

Vue.config.productionTip = false;

const app = new Vue({
    store,
    router,
    render: h => h(App),
}).$mount('#app');
