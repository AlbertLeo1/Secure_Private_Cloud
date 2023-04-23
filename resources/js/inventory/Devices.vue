<template>
<section class="row clearfix mt-5">
    <div class="modal fade" id="userModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ editMode ? 'Edit Device' : 'New Device' }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <HrUserForm :areas="areas" :branches="branches" :departments="departments" :editMode="editMode" :states="states" :user="user"/>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deviceModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ editMode ? 'Edit Device' : 'New Device' }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <InventoryFormDevice :branches="branches" :device="device" :editMode="editMode"/>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Inventory Devices</h3>
                <div class="card-tools">
                    <button class="btn btn-sm btn-primary float-sm-right" @click="addDevice()">Add New Device <i class="fa fa-user-add"></i></button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Device</th>
                            <th>Serial Number</th>
                            <th>Model</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>IP Address</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody v-if="devices.data != null">
                        <tr v-for="device in devices.data" :key="device.id">
                            <td>{{ device.name }}<br /><span class="text-muted">{{ device.brand }}</span></td>
                            <td>{{ device.serial_number }}<br /><span class="text-muted">{{ device.unique_code }}</span></td>
                            <td>{{ device.model }}</td>
                            <td>{{ device.branch.name }}</td>
                            <td>{{ device.status }}</td>
                            <td>{{ device.mac_address }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-default" @click="editDevice(device)">
                                    <i class="fas fa-envelope mr-2 text-primary"></i> Edit
                                    </button>
                                    <div class="dropdown-divider"></div>
                                    <button class="btn btn-default" @click="deleteDevice(device.id)">
                                    <i class="fas fa-trash mr-2 text-danger"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr><td colspan=7>There are no devices currently saved on this system</td></tr>
                    </tbody> 
                </table>
            </div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return {
            areas:[],
            branches:[],
            departments:[],
            device: {},
            devices: {},
            editMode: false,
            savings:{},
            states:[],
            user:{},
            users:{},
            form: new Form({}),
        }
    },
    methods:{
        addDevice(){
            this.editMode = false;
            this.device = {};
            Fire.$emit('DeviceDataFill', {});
            $('#deviceModal').modal('show');
            this.$Progress.finish();
        },
        closeModal(){
            $('#deviceModal').modal('hide');
        },
        deleteDevice(id){
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
                if(result.value){
                    this.form.delete('/api/inventory/devices/'+id)
                    .then(response=>{
                        this.$Progress.finish();
                        Swal.fire('Deleted!', response.data.message, 'success');
                        this.refreshPage(response);   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });  
        },
        editDevice(device){
            this.$Progress.start();
            this.editMode = true;
            this.device = device;
            Fire.$emit('DeviceDataFill', device);
            $('#deviceModal').modal('show');
            this.$Progress.finish();
        },
        getAllInitials(page=1){
            this.$Progress.start();
            axios.get('/api/inventory/devices?page='+page).then(response =>{
                this.refreshPage(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Devices loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Devices not loaded successfully',
                })
            });
        },
        refreshPage(response){
            this.devices = response.data.devices;
            this.branches = response.data.branches;
            this.departments = response.data.departments;
            this.states = response.data.states;
            this.users = response.data.users;
        },
        setUserRole(user){
            this.$Progress.start();
            this.user = user;
            Fire.$emit('userRoleUpdate', user);
            $('#roleModal').modal('show');
            this.$Progress.finish();
        },
    },
    mounted(){ 
        this.getAllInitials();
        Fire.$on('searchInstance', ()=>{
            let query = this.$parent.search;
            axios.get('/api/ums/users/search?q='+query)
            .then((response ) => {this.users = response.data.users;})
            .catch(()=>{});
        });
        Fire.$on('ReloadDevices', response =>{
            this.closeModal();
            this. refreshPage(response);
        });
    },
}
</script>