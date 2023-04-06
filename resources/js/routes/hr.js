import Vue from 'vue';
import VueRouter from 'vue-router';

import HrProfile                        from '../hrms/profile/Profile.vue'
import HrUserSingle                     from '../hrms/users/Single.vue';
import HrUserAll                        from '../hrms/users/All.vue';

    import HrUserForm                   from '../hrms/users/forms/User.vue';
    import HrUserFormRoleAssign         from '../hrms/users/forms/RoleAssign.vue';

Vue.component('HrProfile',                      HrProfile);
Vue.component('HrUserAll',                      HrUserAll);
Vue.component('HrUserSingle',                   HrUserSingle);
    Vue.component('HrUserForm',                 HrUserForm);
    Vue.component('HrUserFormRoleAssign',       HrUserFormRoleAssign);
let routes = [
    {path: '/hr',                           component: HrUserAll},
    {path: '/hr/profile',                   component: HrProfile},
    {path: '/hr/users',                     component: HrUserAll},

    
]

export default routes