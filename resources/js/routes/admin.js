import Vue from 'vue';
import VueRouter from 'vue-router';

import AdminDepartments                 from '../administration/departments/All.vue'
import AdminDepartmentSingle            from '../administration/departments/Single.vue'
import AdminBranches                    from '../administration/branches/All.vue';
import AdminBranch                      from '../administration/branches/Main.vue';
import AdminLogs                        from '../administration/ActivityLog.vue';

    import AdminFormDepartment          from '../administration/departments/Form.vue';
    import AdminFormBranch              from '../administration/branches/Form.vue';

import LogsAll                          from '../activities/All.vue';
import LogsSearch                       from '../activities/Search.vue';

Vue.component('AdminBranches',                  AdminBranches);
Vue.component('AdminDepartments',               AdminDepartments);

    Vue.component('AdminFormDepartment',        AdminFormDepartment);
    Vue.component('AdminFormBranch',            AdminFormBranch);

Vue.component('LogsAll',            LogsAll);
Vue.component('LogsSearch',         LogsSearch);

let routes = [
    {path: '/admin',                            component: AdminDepartments},
    {path: '/admin/departments',                component: AdminDepartments},
    {path: '/admin/departments/:id',            component: AdminDepartmentSingle},
    {path: '/admin/branches',                   component: AdminBranches},
    {path: '/admin/branches/:id',               component: AdminBranch},
    {path: '/admin/logs',                       component: AdminLogs},

]

export default routes