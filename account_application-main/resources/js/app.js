/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

require('vue-ionicons/ionicons.css');
import AllIosIcon from 'vue-ionicons/dist/ionicons-ios.js'

Vue.use(AllIosIcon)

import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

// This imports all the layout components such as <b-container>, <b-row>, <b-col>:
import { LayoutPlugin } from 'bootstrap-vue'
Vue.use(LayoutPlugin)

import Chartkick from 'chartkick'
import Chart from 'chart.js'

Vue.use(Chartkick.use(Chart))

import VueApexCharts from 'vue-apexcharts';
Vue.use(VueApexCharts);

Vue.component('apexchart', VueApexCharts);

import ECharts from 'vue-echarts';
Vue.component('v-chart', ECharts);
import "echarts";

import { ModalPlugin } from 'bootstrap-vue'
Vue.use(ModalPlugin)

// This imports <b-card> along with all the <b-card-*> sub-components as a plugin:
import { CardPlugin } from 'bootstrap-vue'
Vue.use(CardPlugin)

import "chart.js";
import "hchs-vue-charts";
Vue.use(window.VueCharts);

import DataTable from 'laravel-vue-datatable';
window.DataTable = DataTable;
Vue.use(DataTable);

Vue.prototype.$userID = document.querySelector("meta[name='user-id']").getAttribute('content');

//V form
import { AlertError, Form, HasError } from 'vform'
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
//Vue Router
import VueRouter from 'vue-router';
import { routes } from './routes/routes'
Vue.use(VueRouter);
//toastr
import toastr from 'toastr'
window.toastr = toastr;
//Sweet Altert
import Swal from 'sweetalert2'
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.Toast = Toast;

import moment from 'moment'
Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
    }
})

import vSelect from 'vue-select'

Vue.component('v-select', vSelect)

// Vuex
import Vuex from 'vuex'
import storeData from "./store/store";

Vue.use(Vuex)
const store = new Vuex.Store(
    storeData
)
import { jsPDF } from "jspdf";
const pdfDoc = new jsPDF();
import 'jspdf-autotable'
import 'jspdf-html2canvas'
window.pdfDoc = pdfDoc;

const router = new VueRouter({
    routes,
    // mode: 'history',
})

import UUID from 'vue-uuid'
Vue.use(UUID);
window.UUID = UUID;

// import UniqueId from 'vue-unique-id';
// or
const UniqueId = require('vue-unique-id');

Vue.use(UniqueId);
window.UniqueId = UniqueId;
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('home', require('./components/backend/home').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store
});
