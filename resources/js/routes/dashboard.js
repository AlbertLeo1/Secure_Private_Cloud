import Vue from 'vue';
import VueRouter from 'vue-router';

import DashboardMain                 from '../dashboard/Main.vue'


Vue.component('DashboardMain',               DashboardMain);

    //Vue.component('InventoryFormDevice',        InventoryFormDevice);
    
let routes = [
    {path: '/',                 component: DashboardMain},
    {path: '/home',             component: DashboardMain},
    
]

export default routes