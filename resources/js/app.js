/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
/*
const app = new Vue({
    el: '#app',
});
*/

import Vue from 'vue';
import './plugins/vuetify';
import router from './router';
import Vuelidate from 'vuelidate'

import toastPlugin from './plugins/toast';
import commonFunctions from './plugins/common_functions';

import BootstrapVue from "bootstrap-vue";
import 'bootstrap-vue/dist/bootstrap-vue.css';


import App from './App.vue';

import Default from './Layout/Wrappers/baseLayout.vue';
import Pages from './Layout/Wrappers/pagesLayout.vue';
import Apps from './Layout/Wrappers/appLayout.vue';

Vue.config.productionTip = false;

//Миксины
/*
window.componentsCount = 0;
Vue.mixin({
    mounted(){
        window.componentsCount++;
        console.log('Количество компонентов', window.componentsCount );
    }
});
*/


Vue.use(commonFunctions);
Vue.use(toastPlugin);
Vue.use(Vuelidate);
Vue.use(BootstrapVue);
Vue.use(require('vue-cookies'));

Vue.component('default-layout', Default);
Vue.component('userpages-layout', Pages);
Vue.component('apps-layout', Apps);


const app = new Vue({
    el: '#app',
    router,
    template: '<App/>',
    components: { App }
});
