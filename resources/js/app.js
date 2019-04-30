
import './bootstrap';
import Vue from 'vue'
window.Vue = Vue;

import App from './App.vue'
import './plugins/vuetify'
import router from './router'

Vue.config.productionTip = false;

const app = new Vue({
    router,
    render: h => h(App),
}).$mount('#app');
