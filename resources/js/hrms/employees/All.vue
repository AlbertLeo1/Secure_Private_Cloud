<template>
<section>
    <div class="row">
        <div class="col-md-12">
            <div class="row clearfix">
                <div class="modal fade" id="userModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" v-show="editMode">Edit Staff: {{employee.unique_id}}</h4>
                                <h4 class="modal-title" v-show="!editMode">New Staff</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <HrEmployeeForm :branches="branches" :departments="departments" :editMode="editMode" :nations="nations" :states="states" :employee="employee"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="roleModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" v-show="!editMode">Assign Staff Roles</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <HrEmployeeRoleForm :employee="employee" :nations="nations" :departments="departments" :branches="branches"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Staffs</h3>

                            <div class="card-tools">
                                <button class="btn btn-sm btn-primary float-sm-right" @click="addUser()">Add New Staff <i class="fa fa-user-add"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-6 d-flex align-items-stretch" v-for="employee in employees.data" :key="employee.id">
                                    <div class="card bg-light">
                                        <div class="card-header text-muted border-bottom-0">&nbsp;</div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="lead"><b>{{employee.user.first_name}} {{employee.user.middle_name}} {{employee.user.last_name}}</b></h2>
                                                </div>
                                                <div class="col-5 text-center">
                                                    <img style="height: 100px;" :src="(employee.user.image) ? '/img/profile/'+employee.user.image : '/img/profile/default.png'" alt="" class="img-circle img-fluid">
                                                </div>
                                                <div class="col-12">
                                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> Email: {{employee.official_email}} | {{employee.user.email}}</li>
                                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Roles: {{(employee.user.roles != null && (typeof (employee.user.roles) != 'undefined')) ? ', Patient' : 'Patient only' }}</li>
                                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: {{employee.user.phone}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                                <button class="btn btn-sm btn-success" @click="setUserRole(employee.user)" title="Set Staff Role"><i class="fa fa-user-cog"></i></button>
                                                <button class="btn btn-sm btn-primary" @click="editUser(employee)" title="Edit Staff"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-sm btn-danger" @click="deleteUser(employee.id)" title="Delete Staff"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card-footer">
                                <pagination :data="employees" @pagination-change-page="getEmployee">
                                    <span slot="prev-nav">&lt; Previous </span>
                                    <span slot="next-nav">Next &gt;</span>
                                </pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return {
            branches:[],
            departments:[],
            editMode: false,
            employee: {},
            employees: {},
            nations: [],
            states:[],
            form: new Form({}),
        }
    },
    methods:{
        addUser(){
            this.editMode = false;
            this.user = {};
            Fire.$emit('BioDataFill', this.user);
            $('#userModal').modal('show');
            this.$Progress.finish();
        },
        closeModal(){
            $('#userModal').modal('hide');
        },
        deleteUser(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                })
            .then((result) => {
                if(result.value){
                    this.form.delete('/api/hrms/employees/'+id)
                    .then(response=>{
                        Swal.fire('Deleted!', response.data.message, 'success');
                        this.refreshPage(response);   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });  
        },
        editUser(employee){
            this.$Progress.start();
            this.editMode = true;
            this.employee = employee;
            Fire.$emit('BioDataFill', employee);
            $('#userModal').modal('show');

            this.$Progress.finish();
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/hrms/employees').then(response =>{
                this.refreshPage(response);
                this.$Progress.finish();
                toast.fire({icon: 'success', title: 'Staffs loaded successfully',});
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({icon: 'error', title: 'Staffs were not loaded successfully',});
            });
        },
        getEmployee(page=1){
            axios.get('/api/hrms/employees?page='+page)
            .then(response=>{
                this.users = response.data.users;   
            });
        },
        refreshPage(response){
            this.branches = response.data.branches;
            this.departments = response.data.departments;
            this.nations = response.data.nations;
            this.employees = response.data.employees;
        },
        setUserRole(user){
            this.$Progress.start();
            this.user = user;
            Fire.$emit('userRoleUpdate', user);
            $('#roleModal').modal('show');
            this.$Progress.finish();
        },
    },
    mounted(){ 
        this.getAllInitials();
        Fire.$on('searchInstance', ()=>{
            let query = this.$parent.search;
            axios.get('/api/hrms/employees?q='+query)
            .then((response ) => {this.employees = response.data.employees;})
            .catch(()=>{});
        });
        Fire.$on('userRoleReload', response =>{});
        Fire.$on('Reload', response =>{
            $('#userModal').modal('hide'); 
            $('#roleModal').modal('hide');
            this.employees = response.data.employees;
        });
    },
}
</script>