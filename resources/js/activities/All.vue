<template>
<section class="row">
<div class="col-12">
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Activity Logs</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Time Stamp</th>
                        <th>Subject</th>
                        <th>Agent</th>
                        <th>IP Address</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(activity, index) in log_activities.data" >
                        <td>{{ index | addOne }}</td>
                        <td>{{ activity.created_at | ExcelTimestamp }}</td>
                        <td>{{ activity.subject }}</td>
                        <td>{{ activity.agent }}</td>
                        <td>{{ activity.ip }}</td>
                        <td></td>
                    </tr>
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
            log_activities: {},
            form: new Form({}),
        }
    },
    methods:{
        addActivity(){
            this.log = {};
            this.editMode = false;
            Fire.$emit('logDataFill', {});
            $('#logModal').modal('show'); 
        },
        closeModal(){
            $('#logModal').modal('hide'); 
        },
        deleteActivity(id){
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
                //Send Delete request
                if(result.value){
                    this.form.delete('/api/ums/logs/'+id)
                    .then(response=>{
                        Swal.fire('Deleted!', response.data.message, 'success');
                        this.refreshPage(response);   
                    })
                    .catch(()=>{
                        Swal.fire({icon: 'error', title: 'Oops...', text: 'Something went wrong!', footer: '<a href>Why do I have this issue?</a>'});
                    });
                }
            });
        },        
        editActivity(log){
            this.editMode = true;
            this.log = log;
            Fire.$emit('logDataFill', log);
            $('#logModal').modal('show'); 
        },
        getAllInitials(page=1){
            this.$Progress.start();
            axios.get('/api/logs/activities?page='+page)
            .then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Logs were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Logs were not loaded successfully',
                })
            });
        },
        refresh(response){
            this.log_activities = response.data.log_activities;
        },
    },
    mounted() {
        this.getAllInitials();
        Fire.$on('branchRefresh', response =>{
            this.refresh(response);
            this.closeModal();
        });
        Fire.$on('branchUpdate', branch=>{
            this.branch = branch;
        });
        Fire.$on('getBranch', response =>{
            this.refresh(response);
            $('#branchModal').modal('hide');
        });
    }
}
</script>