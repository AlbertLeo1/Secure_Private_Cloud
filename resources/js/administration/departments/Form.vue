<template>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="editMode ? updateDepartment() : createDepartment() ">
                    <alert-error :form="departmentData"></alert-error> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name *" v-model="departmentData.name" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Head of Department</label>
                                <select class="form-control" id="_id" name="_id" v-model="departmentData.hod_id" required>
                                    <option value="">--Select Head of Department--</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">{{user.username+' | '+user.first_name+' '+user.last_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Name *"  v-model="departmentData.email" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Phone Extension</label>
                                <input type="text" class="form-control" id="ext" name="ext" placeholder="Phone Ext "  v-model="departmentData.ext_phone">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" id="description" name="description" rows=5 placeholder="A full description of the Course" v-model="departmentData.description"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
                </form>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return  {
            departmentData: new Form({
                id: '',
                name: '', 
                email: '',
                ext: '',
                description:'', 
                hod_id:'',
            }),
            users: [],
        }
    },
    mounted() {
        this.getInitials();
        Fire.$on('DepartmentDataFill', department =>{
            this.departmentData.fill(department)
        });
        Fire.$on('AfterCreation', ()=>{
        });
    },
    methods:{
        createDepartment(){
            this.$Progress.start();
            this.departmentData.post('/api/ums/departments')
            .then(response =>{
                Fire.$emit('DepartmentRefresh', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Department'+ this.departmentData.name+' has been created',
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });
            this.$Progress.finish();
            this.departmentData.clear();
        },
        getInitials(){
            axios.get('/api/ums/departments/initials').then(response =>{
                this.users = response.data.users;
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Users were not loaded successfully',
                })
            });
        },
        updateDepartment(){
            this.$Progress.start();
            this.departmentData.put('/api/ums/departments/'+ this.departmentData.id)
            .then(response =>{
                Fire.$emit('DepartmentRefresh', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Department '+this.departmentData.name+' has been updated',
                    showConfirmButton: false,
                    timer: 1500
                });
                this.$Progress.finish();
                this.departmentData.clear();
            })
            .catch(()=>{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: 'Please try again later!'
                });
                this.$Progress.fail();
            });            
        },
    },
    props:{ editMode: Boolean, }
}
</script>
