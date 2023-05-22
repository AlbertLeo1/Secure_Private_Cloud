require('./bootstrap');
import router from './routes';

window.Vue = require('vue');
import Vue from 'vue';

//Import Progress Bar
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, { color: 'rgb(255, 255, 19)', failedColor: 'red', height: '5px', });

//Import Horizontal Slider
import VueHorizontalList from 'vue-horizontal-list';
Vue.use(VueHorizontalList);


//Import Sweet Alert
import Swal from 'sweetalert2'
window.Swal = Swal;

const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.toast = toast;
//Import Moment for DateTime functions
import moment from 'moment';


//Import VueRouter for SPA Routing
import VueRouter from 'vue-router';
Vue.use(VueRouter);

//Import Simple Pagination
Vue.component('pagination', require('laravel-vue-pagination'));

//Import Vform for forms and Errors
import { Form, HasError, AlertError } from 'vform';
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
window.Form = Form;


//Import Chart and ChartKick for Charts
import Chart from 'chart.js';
import Chartkick from 'vue-chartkick'
Vue.use(Chartkick.use(Chart));

//Import Emit for all components
window.Fire = new Vue();

//Import WYSIWYG
import wysiwyg from "vue-wysiwyg";
Vue.use(wysiwyg, {});
import "vue-wysiwyg/dist/vueWysiwyg.css";

//Special Created Filters
Vue.filter('addOne', function (value) {
    if (isNaN(value)) { return '0'; }
    let val = value + 1;
    return val;
});

Vue.filter('age', function (value) {
    return moment().diff(moment(value, "DD MMM YYYY"), 'years');
});

Vue.filter('capitalize', function (text) {
    if (text == '') { return ''; }
    const capitalized = text.charAt(0).toUpperCase() + text.slice(1);
    return capitalized;
});

Vue.filter('currency', function (value) {
    if (isNaN(value)) { return '0.00'; }
    let val = (value / 1).toFixed(2).replace(',', '.')
    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
});

Vue.filter('ExcelDate', function (text) {
    return moment(text).format('MMMM Do, YYYY');
});

Vue.filter('ExcelDateShort', function (text) {
    return moment(text).format('DD/MM/YYYY');
});

Vue.filter('ExcelDateMonth', function (text) {
    return moment(text).format('MMM Do');
});

Vue.filter('ExcelTimestamp', function (text) {
    return moment(text).format('MMMM Do, YYYY \n H:m:s');
});

Vue.filter('ExcelMonthYear', function (text) {
    return moment(text).format('MMM, YYYY');
});

Vue.filter('FullDate', function (text) {
    return moment(text).format('LLLL');
});

Vue.filter('FullName', function (text) {
    if (text == null) { return 'Old Patient'; }
    else {
        let full_name = text.first_name + ' ' + (text.middle_name != null ? text.middle_name : '') + ' ' + text.last_name;
        return full_name;
    }
});

Vue.filter('FullNameStaff', function (text) {
    if (text == null || text.user == null) { return 'Old Staff'; }
    else {
        let full_name = text.unique_id + ' | ' + text.user.first_name + ' ' + (text.user.middle_name != null ? text.user.middle_name : '') + ' ' + text.user.last_name;
        return full_name;
    }
});

Vue.filter('firstUp', function (text) {
    return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
});

Vue.filter('patientName', function (text) {
    if (text == null) { return 'Old Patient'; }
    else {

        let full_name = (text.title != null ? text.title : '') + ' ' + text.first_name + ' ' + (text.middle_name != null ? text.middle_name : '') + ' ' + text.last_name;
        return full_name;
    }
});

Vue.filter('readMore', function (text, length, suffix) {
    if (text == null) { return text; }
    else if (text.length <= length) { return text; }
    else { return text.substring(0, length) + suffix; }
});

Vue.filter('recentDate', function (text) {
    return moment(text).format('MMMM Do, YYYY');
});

Vue.filter('shortDate', function (text) {
    return moment(text).format('MMM Do, YY');
});

Vue.filter('profilePicture', function (text) {
    if (text == null) { return '/img/profile/default.png'; }
    else { return '/img/profile/' + text; }
});

//Users Components

const app = new Vue({
    el: '#corner',
    router,
    data: { search: '', },
    methods: { searchIt: _.debounce(() => { Fire.$emit('searchInstance'); }, 1000) },

});
