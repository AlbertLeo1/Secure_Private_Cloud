<template>
<div class="row clearfix">
    <div class="modal fade" id="roleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-show="editMode">Edit Role: {{role.name}}</h4>
                    <h4 class="modal-title" v-show="!editMode">New Role</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <UserFormRole :role="role"/>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Roles</h3>

                <div class="card-tools">
                    <button class="btn btn-sm btn-primary float-sm-right" @click="add()">Add New Role <i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="role in roles.data" :key="role.id">
                            <td><strong>{{role.name}} </strong><br/><small>{{role.created_at | ExcelDate}}</small></td>
                            <td>
                                <ul class="list-inline">
                                    <li class="list-inline-item" v-for="member in role.users" :key="member.id">
                                        <img alt="Avatar" class="table-avatar" src="/dist/img/avatar.png">
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-success" @click="seeRole(role)"><i class="fas fa-folder"></i> View</button>
                                <button class="btn btn-sm btn-primary" @click="editRole(role)"><i class="fas fa-pencil-alt"></i> Edit</button>
                                <button class="btn btn-sm btn-danger" @click="deleteRole(role.id)"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="col-12">
                    <pagination :data="roles" @pagination-change-page="getRoles">
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
            areas:[],
            branches:[],
            departments:[],
            editMode: false,
            role: {},
            roles:{},
            savings:{},
            states:[],
            user:{},
            users:{},
            form: new Form({}),
        }
    },
    methods:{
        add(){
            this.editMode = false;
            this.user = {};
            Fire.$emit('BioDataFill', this.user);
            $('#userModal').modal('show');

            this.$Progress.finish();
        },
        deleteRole(id){
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
                //Send Delete request
                if(result.value){
                    this.form.delete('/api/ums/roles/'+id)
                    .then(response=>{
                    Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                    Fire.$emit('CatRefresh', response);   
                    })
                    .catch(()=>{
                    Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });  
        },
        editRole(role){
            this.$Progress.start();
            this.editMode = true;
            this.role = role;
            Fire.$emit('RoleDataFill', role);
            $('#roleModal').modal('show');

            this.$Progress.finish();
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/ums/roles').then(response =>{
                this.roles = response.data.roles
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Roles loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Users not loaded successfully',
                })
            });
        },
        getRoles(page=1){
            axios.get('/api/ums/roles?page='+page)
            .then(response=>{
                this.roles = response.data.roles;   
            });
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('searchInstance', ()=>{
            let query = this.$parent.search;
            axios.get('/api/ums/roles/search?q='+query)
            .then((response ) => {
                this.users = response.data.users;
            })
            .catch(()=>{

            });
        });
    },
}
</script>
