import Vue from 'vue';
import VueRouter from 'vue-router';

import AdminDepartments                 from '../administration/departments/All.vue'
import AdminBranches                    from '../administration/branches/All.vue';

    import AdminFormDepartment          from '../administration/departments/Form.vue';
    import AdminFormDepartment          from '../administration/branches/Form.vue';

Vue.component('AdminBranches',                  AdminBranches);
Vue.component('AdminDepartments',               AdminDepartments);

    Vue.component('AdminFormDepartment',        AdminFormDepartment);
    Vue.component('AdminFormBranch',            AdminFormBranch);

let routes = [
    {path: '/admin',                            component: AdminDepartments},
    {path: '/admin/departments',                component: AdminDepartments},
    {path: '/admin/branches',                   component: AdminBranches},

    
]

export default routes