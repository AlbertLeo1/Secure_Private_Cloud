<template>
<section class="row">
    <div class="col-lg-6 col-12">
        <div class="small-box bg-info">
            <div class="inner"><h3>{{ all_devices }}</h3><p>All Devices</p></div>
            <div class="icon"><i class="fa fa-desktop"></i></div>
            <router-link to="/inventory/devices" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></router-link>
        </div>
    </div>
    <div class="col-lg-6 col-12">
            <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner"><h3>{{ new_devices }}</h3><p>New Devices</p></div>
            <div class="icon"><i class="fa fa-reply"></i></div>
            <a href="/inventory/device/new" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="small-box bg-danger">
            <div class="inner"><h3>{{ damaged_devices }}</h3><p>Damaged Devices</p></div>
            <div class="icon"><i class="fa fa-times-circle"></i></div>
            <a href="/inventory/device/damaged" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="small-box bg-warning">
            <div class="inner"><h3>{{ repaired_devices }}</h3><p>Repaired Devices</p></div>
            <div class="icon"><i class="fa fa-wrench"></i></div>
            <a href="/inventory/device/repaired" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="small-box bg-dark">
            <div class="inner"><h3>{{ due_devices }}</h3><p>Due for Maintenance Devices</p></div>
            <div class="icon"><i class="fa fa-calendar"></i></div>
            <a href="/inventory/device/due" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="small-box bg-default">
            <div class="inner"><h3>{{ sold_devices }}</h3><p>Sold Devices</p></div>
            <div class="icon"><i class="fa fa-wrench"></i></div>
            <a href="/inventory/device/sold" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return {
            new_devices: 0,
            all_devices: 0,
            damaged_devices: 0,
            due_devices: 0,
            sold_devices: 0,
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
            axios.get('/api/ums/branches/'+this.$route.params.id).then(response =>{
                this.refreshPage(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Dashboard loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Dashboard not loaded successfully',
                })
            });
        },
        refreshPage(response){
            this.all_devices = response.data.all_devices;
            this.damaged_devices = response.data.damaged_devices;
            this.new_devices = response.data.new_devices;
            this.repaired_devices = response.data.repaired_devices;
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