import Vue from 'vue';
import VueRouter from 'vue-router';

import InventoryDevices                 from '../inventory/Devices.vue';
import InventoryDevicesByStatus         from '../inventory/DevicesByStatus.vue';
    import InventoryFormDevice          from '../inventory/forms/Device.vue';

Vue.component('InventoryDevices',               InventoryDevices);
Vue.component('InventoryDevicesByStatus',       InventoryDevicesByStatus);

    Vue.component('InventoryFormDevice',        InventoryFormDevice);
    
let routes = [
    {path: '/inventory',                    component: InventoryDevices},
    {path: '/inventory/devices',            component: InventoryDevices},
    {path: '/inventory/device/:status',     component: InventoryDevicesByStatus},
    
]

export default routes