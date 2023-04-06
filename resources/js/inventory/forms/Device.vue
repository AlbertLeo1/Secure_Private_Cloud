<template>
<form id="register_form">    
    <div class="row">
        <div class="col-sm-9">
            <div class="form-group">
            <label>Name *</label>
            <input type="text" class="form-control" id="nok_name" name="nok_name" placeholder="Full Name *" required  v-model="nokForm.name" :class="{'is-invalid' : nokForm.errors.has('name') }">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
            <label>Brand *</label>
            <input type="text" class="form-control" id="brand" name="brand" placeholder="Brand *" required v-model="nokForm.brand" :class="{'is-invalid' : nokForm.errors.has('brand') }">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
            <label>Serial Number *</label>
            <input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="serial_number *" required v-model="nokForm.serial_number" :class="{'is-invalid' : nokForm.errors.has('serial_number') }">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
            <label>Inventory Code *</label>
            <input type="text" class="form-control" id="unique_code" name="unique_code" placeholder="unique_code *" required v-model="nokForm.unique_code" :class="{'is-invalid' : nokForm.errors.has('unique_code') }">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
            <label>Model *</label>
            <input type="text" class="form-control" id="model" name="model" placeholder="model *" required v-model="nokForm.model" :class="{'is-invalid' : nokForm.errors.has('model') }">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Branch</label>
                <select class="form-control" id="branch_id" name="branch_id" placeholder="branch_id *" required v-model="nokForm.branch_id" :class="{'is-invalid' : nokForm.errors.has('branch_id') }">
                    <option value=''>--Select Branch</option>
                    <option v-for="branch in branches" :key="branch.id" :value="branch.id">{{ branch.name }}</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
            <label>Inventory Code *</label>
            <input type="text" class="form-control" id="unique_code" name="unique_code" placeholder="unique_code *" required v-model="nokForm.unique_code" :class="{'is-invalid' : nokForm.errors.has('unique_code') }">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
            <label>Model *</label>
            <input type="text" class="form-control" id="model" name="model" placeholder="model *" required v-model="nokForm.model" :class="{'is-invalid' : nokForm.errors.has('model') }">
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
    <button @click.prevent="editMode ? updateDevice() : createDevice()" type="submit" name="submit" class="submit btn btn-success">Submit </button>
</form>
</template>
<script>
export default {
    data(){
        return {
            deviceForm: new Form({
                id:'',
                name:'',
                brand:'',
                serial_number:'',
                unique_code: '', 
                model: '', 
                branch_id: '', 
                description: '', 
                status: '', 
                mac_address: '',
            }),
            editMode:false,
        }
    },
    methods:{
        createDevice(){
            this.$Progress.start();
            this.deviceForm.put('/api/inventory/devices/'+this.deviceForm.id)
            .then(response =>{
                this.$Progress.finish();
                Swal.fire({
                    icon: 'success',
                    title: 'The Device details has been created',
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
        updateDevice(){
            this.$Progress.start();
            this.deviceForm.put('/api/inventory/devices/'+this.deviceForm.id)
            .then(response =>{
                this.$Progress.finish();
                Swal.fire({
                    icon: 'success',
                    title: 'The Device details has been updated',
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
        Fire.$on('DeviceDataFill', device =>{
            this.editMode = true;
            this.deviceForm.fill(device);
        });
    },
    props:{
        'branches': Array,
    },
}
</script>