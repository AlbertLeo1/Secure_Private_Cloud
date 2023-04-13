import Vue from 'vue';
import VueRouter from 'vue-router';

import admin from './admin';
//import domiciliary from './domiciliary';
//import hims from './hims';
import hr from './hr';
import inventory from './inventory';
//import nursing from './nursing';
//import operations from './operations';
//import policies from './policies';

const baseRoutes = [];
const routes = baseRoutes.concat( admin,//applicant, domiciliary, hims, 
hr, inventory, //learn, nursing, operations, policies,
);

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router