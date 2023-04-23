<template>
<form id="register_form">    
    <div class="row">
        <div class="col-sm-9">
            <div class="form-group">
            <label>Name *</label>
            <input type="text" class="form-control" id="nok_name" name="nok_name" placeholder="Full Name *" required  v-model="deviceForm.name" :class="{'is-invalid' : deviceForm.errors.has('name') }">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
            <label>Brand *</label>
            <input type="text" class="form-control" id="brand" name="brand" placeholder="Brand *" required v-model="deviceForm.brand" :class="{'is-invalid' : deviceForm.errors.has('brand') }">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
            <label>Serial Number *</label>
            <input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="serial_number *" required v-model="deviceForm.serial_number" :class="{'is-invalid' : deviceForm.errors.has('serial_number') }">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
            <label>Inventory Code *</label>
            <input type="text" class="form-control" id="unique_code" name="unique_code" placeholder="unique_code *" required v-model="deviceForm.unique_code" :class="{'is-invalid' : deviceForm.errors.has('unique_code') }">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
            <label>Model *</label>
            <input type="text" class="form-control" id="model" name="model" placeholder="model *" required v-model="deviceForm.model" :class="{'is-invalid' : deviceForm.errors.has('model') }">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" id="status" name="status" placeholder="status *" required v-model="deviceForm.status" :class="{'is-invalid' : deviceForm.errors.has('status') }">
                    <option value=''>--Select Status--</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Discontinued">Discontinued</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
            <label>IP Address *</label>
            <input type="text" class="form-control" id="mac_address" name="mac_address" placeholder="mac_address *" required v-model="deviceForm.mac_address" :class="{'is-invalid' : deviceForm.errors.has('mac_address') }">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
            <label>Branch *</label>
                <select class="form-control" id="branch_id" name="branch_id" required v-model="deviceForm.branch_id" :class="{'is-invalid' : deviceForm.errors.has('branch_id') }">
                    <option value=''>--Select Status--</option>
                    <option v-for="branch in branches" :value="branch.id">{{branch.name}}</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label>Description</label>
                <wysiwyg type="text" rows="5" id="description" name="description" placeholder="Enter description *" required v-model="deviceForm.description" :class="{'is-invalid' : deviceForm.errors.has('description') }" />
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
        }
    },
    methods:{
        createDevice(){
            this.$Progress.start();
            this.deviceForm.post('/api/inventory/devices')
            .then(response =>{
                Fire.$emit('ReloadDevices', response);
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
            this.deviceForm.fill(device);
        });
    },
    props:{
        'branches': Array,
        'editMode': Boolean,
    },
}
</script>