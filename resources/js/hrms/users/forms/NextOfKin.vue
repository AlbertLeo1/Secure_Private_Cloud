<template>
<form id="register_form" >    
    <div class="row">
        <div class="col-sm-9">
            <div class="form-group">
            <label>Name *</label>
            <input type="text" class="form-control" id="nok_name" name="nok_name" placeholder="Full Name *" required  v-model="nokForm.name" :class="{'is-invalid' : nokForm.errors.has('name') }">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
            <label>Relationship *</label>
            <input type="text" class="form-control" id="relationship" name="relationship" placeholder="Relationship *" required v-model="nokForm.relationship" :class="{'is-invalid' : nokForm.errors.has('relationship') }">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" id="nok_address" name="address" placeholder="Enter Address *" required v-model="nokForm.address" :class="{'is-invalid' : nokForm.errors.has('address') }">
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Phone Number*</label>
                <input type="number" class="form-control" id="nok_phone" name="phone" placeholder="Enter Phone Number *" value="" required v-model="nokForm.phone" :class="{'is-invalid' : nokForm.errors.has('phone') }">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" id="nok_email" name="email" placeholder="Enter NOK Email Address *" required v-model="nokForm.email" :class="{'is-invalid' : nokForm.errors.has('email') }">
            </div>
        </div>
    </div>
    <button @click.prevent="updateNextofKin" type="submit" name="submit" class="submit btn btn-success">Submit </button>
</form>
</template>
<script>
    export default {
        data(){
            return {
                nokForm: new Form({
                    id:'',
                    name:'',
                    relationship:'',
                    address:'',
                    email:'',
                    phone:'',
                }),
                editMode:false,
            }
        },
        methods:{
            updateNextofKin(){
                this.$Progress.start();
                this.nokForm.post('/api/hrms/nok')
                .then(response =>{
                    this.$Progress.finish();
                    Swal.fire({
                        icon: 'success',
                        title: 'The Next of Kin details has been updated',
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
            
        },
        mounted() {
            this.nokForm.fill(this.nok);
            Fire.$on('NextOfKinFill', update =>{
                this.editMode = true;
                this.nokForm.fill(update);
            });
        },
        props:{
            'nok': Object,
        },
    }
</script>