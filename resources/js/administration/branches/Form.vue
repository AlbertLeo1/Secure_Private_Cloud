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
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" id="address" name="address" rows=5 placeholder="A full address of the branch" v-model="branchData.address"></textarea>
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
                address: '',
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
            this.branchData.post('/api/ums/branches')
            .then(response =>{
                Fire.$emit('branchRefresh', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Branch '+ this.branchData.name+' has been created',
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
            this.branchData.put('/api/ums/branches/'+ this.branchData.id)
            .then(response =>{
                Fire.$emit('branchRefresh', response);
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
    props:{editMode: Boolean,}
}
</script>
