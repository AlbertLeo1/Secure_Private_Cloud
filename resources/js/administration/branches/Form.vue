<template>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="editMode ? updateBranch() : createBranch() ">
                    <alert-error :form="branchData"></alert-error> 
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name *" v-model="branchData.name" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Location</label>
                                <select class="form-control" id="state_id" name="_id" v-model="branchData.hod_id" required>
                                    <option value="">--Select Head of Department--</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">{{user.unique_id+' | '+user.first_name+' '+user.last_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Name *"  v-model="branchData.email" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Phone Extension</label>
                                <input type="text" class="form-control" id="ext" name="ext" placeholder="Phone Ext "  v-model="branchData.ext_phone">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" id="description" name="description" rows=5 placeholder="A full description of the Course" v-model="branchData.description"></textarea>
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
            branchData: new Form({
                id: '',
                name: '', 
                location: '',
                address: '',
                description:'', 
            }),
        }
    },
    mounted() {
        Fire.$on('branchDataFill', branch =>{
            this.branchData.fill(branch);    
        });
    },
    methods:{
        createBranch(){
            this.$Progress.start();
            this.departmentData.post('api/admin/branches')
            .then(response =>{
                Fire.$emit('DepartmentRefresh', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Department'+ this.branchData.name+' has been created',
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
            this.branchData.clear();
        },
        updateBranch(){
            this.$Progress.start();
            this.branchData.put('/api/ums/departments/'+ this.branchData.id)
            .then(response =>{
                Fire.$emit('DepartmentRefresh', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Department '+this.branchData.name+' has been updated',
                    showConfirmButton: false,
                    timer: 1500
                });
                this.$Progress.finish();
                this.branchData.clear();
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
    props:{department: Object, editMode: Boolean, users: Array,}
}
</script>
