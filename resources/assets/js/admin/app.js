import Vue from 'vue'

import 'font-awesome-webpack'

import ElementUI from 'element-ui'
Vue.use(ElementUI);

import app_store from './store';
import app_router from './router';

Vue.prototype.$refresh = function(path){
    app_router.replace({path: '/refresh', query: {menu: path}})
};

import * as filters from './filters'
Object.keys(filters).forEach(key=>{
    Vue.filter(key,filters[key])
});

import App from './app.vue'
const app = new Vue({
    el: '#app',
    template: '<App/>',
    router: app_router,
    store: app_store,
    components: {App}
});
