import Vue from 'vue';
import VueRouter from 'vue-router';

//import applicant from './applicant';
//import domiciliary from './domiciliary';
//import hims from './hims';
import hr from './hr';
//import learn from './learn';
//import nursing from './nursing';
//import operations from './operations';
//import policies from './policies';

const baseRoutes = [];
const routes = baseRoutes.concat(//applicant, domiciliary, hims, 
hr, //learn, nursing, operations, policies,
);

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router