<template>
<section>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Branches</h3>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table m-b-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="department in departments.data" :key="department.id">
                                        <td>{{department.name}}</td>
                                        <td>{{department.address}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <router-link :to="'/departments/'+department.id" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></router-link>
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
</section>
</template>
<script>
export default {
    data(){
        return {
            branches: {},
        }
    },
    methods:{
        closeModal(){

        },
        getAllInitials(page=1){
            this.$Progress.start();
            axios.get('/api/admin/branches?page='+page)
            .then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Branches were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Branches were not loaded successfully',
                })
            });
        },
        refresh(response){
            this.branches = response.data.branches;
            this.users = response.data.users;
            //Fire.$emit('LecturerFill', this.users);
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('BranchRefresh', response =>{
            this.refresh(response);
            this.closeModal();
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