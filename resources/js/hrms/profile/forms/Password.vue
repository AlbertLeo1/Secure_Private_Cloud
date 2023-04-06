<template>
    <form id="password_form" @submit.prevent="changePassword">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <div class="form-group">
                    <label>Current Password*</label>
                    <input type="password" class="form-control" id="opw" name="opw" placeholder="Enter Current Password" v-model="pwForm.opw" required>
                </div>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="form-group">
                    <label>New Password*</label>
                    <input type="password" class="form-control" id="npw" name="npw" placeholder="New Password"  v-model="pwForm.npw" minlength="8" required>
                </div>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="form-group">
                    <label>Confirm New Password*</label>
                    <input type="password" class="form-control" id="cpw" name="cpw" placeholder="Re-enter New Password"  v-model="pwForm.cpw" required>
                </div>
            </div>
        </div>
        <input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
    </form>
</template>
<script>
    export default {
        data(){
            return {
                pwForm: new Form({
                    opw: '',
                    npw: '',
                    cpw: '',
                }),
            }
        },
        methods:{
            changePassword(){
                if (this.pwForm.npw != this.pwForm.cpw){ 
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Your new passwords do not match',
                        footer: 'Please try again later!'
                        }); 
                    }
                else{
                this.$Progress.start();
                this.pwForm.post('/api/hrms/password')
                .then(response =>{
                    this.$Progress.finish();
                    Swal.fire({
                        icon: response.data.status,
                        title: 'Oops...',
                        text: response.data.message,
                        footer: 'Please try again later!'
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
                }    
            },          
        },
        mounted() {},
        props:{},
    }
</script>