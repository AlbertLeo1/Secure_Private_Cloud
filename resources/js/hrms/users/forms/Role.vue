<template>
<div>
<form>
    <alert-error :form="RoleData"></alert-error> 
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Name *</label>
                <input type="text" required class="form-control" id="name" name="name" placeholder="Name *" v-model="RoleData.name" :class="{'is-invalid' : RoleData.errors.has('name') }">
                <has-error :form="RoleData" field="name"></has-error> 
            </div>
        </div>
    </div>
    <div class="row">
        <label class="col-sm-12">Permissions</label>
        <div class="col-sm-3" v-for="permission in permissions" :key="permission.id">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="departments[]" id="departments[]" v-model="assignData.permissions" :value="department.id" :checked="assignData.departments.includes(department.id)">
                <label class="form-check-label">{{permission.name}}</label>
            </div>
        </div> 
        <input type="hidden" name="id" id="id" v-model="RoleData.id">
    </div>
    <button @click.prevent="updateRoleData" type="submit" name="submit" class="submit btn btn-success">Submit</button>
</form>
</div>
</template>
<script>
export default {
    data(){
        return  {
            RoleData: new Form({
                name: '', 
                permissions:[], 
            }),
        }
    },
    mounted() {
        Fire.$on('RoleDataFill', role =>{
            this.RoleData.fill(role);
        });
        Fire.$on('AfterCreation', ()=>{
            //axios.get("api/profile").then(({ data }) => (this.RoleData.fill(data)));
        });
    },
    methods:{
        updateRoleData(){
            this.$Progress.start();
            this.RoleData.post('/api/hrms/bios')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Profile details has been updated',
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
                    
        },
        getProfilePic(){
            let photo = (this.RoleData.image.length >= 150) ? this.RoleData.image : "./"+this.RoleData.image;
            return photo;
            },
        updateProfilePic(e){
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file['size'] < 2000000){
                reader.onloadend = (e) => {
                    this.RoleData.image = reader.result
                    }
                reader.readAsDataURL(file)
            }
            else{
                Swal.fire({
                    type: 'error',
                    title: 'File is too large'
                })
            }
        },
    },
    props:{
        areas: Array,
        branches: Array, 
        departments: Array, 
        states: Array,
        user: Object,
        editMode: Boolean,
    }
}
</script>
