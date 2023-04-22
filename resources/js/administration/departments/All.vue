<template>
<div class="container-fluid">
    <div class="modal fade" id="departmentModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-show="editMode">EditDepartment: {{department.namme}}</h4>
                    <h4 class="modal-title" v-show="!editMode">New Department</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <AdminFormDepartment :editMode="editMode"/>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Departments</h3>
                    <div class="card-tools">
                        <button class="btn btn-xs btn-primary" @click="addDepartment()">Add New</button>
                    </div>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>HOD</th>
                                    <th>Email</th>
                                    <th>Phone Ext.</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="department in departments.data" :key="department.id">
                                    <td>{{department.name}}</td>
                                    <td>{{department.hod_id !== null && department.hod != null ? department.hod.first_name+' '+department.hod.last_name : ''}}</td>
                                    <td>{{department.email}}</td>
                                    <td>{{department.ext}}</td>
                                    <td>{{department.users.length}}</td>
                                    <td :title="department.description">{{department.description | readMore(25, '...')}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link :to="'/admin/departments/'+department.id" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></router-link>
                                        </div>          
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <pagination :data="departments" @pagination-change-page="getDepartments">
                        <span slot="prev-nav">&lt; Previous </span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return {
            department: {},
            departments: {},
        }
    },
    methods:{
        addDepartment(){
            this.$Progress.start();
            this.editMode = false;
            this.department = {};
            Fire.$emit('departmentDataFill', {});
            $('#departmentModal').modal('show');

            this.$Progress.finish();
        },
        closeModal(){
            $('#departmentModal').modal('hide'); 
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/ums/departments').then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Departments were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Departments were not loaded successfully',
                })
            });
        },
        getDepartments(page=1){
            axios.get('/api/ums/departments?page='+page)
            .then(response=>{
                this.departments = response.data.departments;   
            });
        },
        refresh(response){
            this.departments = response.data.departments;
            this.users = response.data.users;
            //Fire.$emit('LecturerFill', this.users);
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('DepartmentRefresh', response =>{
            this.refresh(response);
            $('#DepartmentModal').modal('hide');
        });
        Fire.$on('DepartmentUpdate', Department=>{
            this.Department = Department;
        });
        Fire.$on('GetDepartment', response =>{
            this.refresh(response);
            $('#DepartmentModal').modal('hide');
        });
    }
}
</script>