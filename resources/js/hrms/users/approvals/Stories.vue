<template>
<section>

</section>
</template>
<script>
export default {
    data(){
        return {
            new_users: 10,
            pending_agency: 0,
            pending_provider: 0,
            pending_stories: 0,

            branches:[],
            departments:[],
            editMode: false,
            savings:{},
            states:[],
            user:{},
            users:{},
            form: new Form({}),
        }
    },
    methods:{
        approveItem(id){
            this.editMode = false;
            this.user = {};
            Fire.$emit('BioDataFill', this.user);
            $('#userModal').modal('show');
            this.$Progress.finish();
        },
        rejectItem(id){
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
                    this.form.delete('/api/ums/users/'+id)
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
        viewItem(item){
            this.$Progress.start();
            this.story = item;
            this.editMode = true;
            //this.user = user;
            Fire.$emit('BioDataFill', user);
            $('#userModal').modal('show');

            this.$Progress.finish();
        },
        getAllInitials(){
            this.$Progress.start();
            axios.get('/api/blogs/approvals').then(response =>{
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
        getStories(page=1){
            axios.get('/api/blogs/approvals?page='+page)
            .then(response=>{
                this.refreshPage(response);   
            });
        },
        refreshPage(response){
            this.new_users= response.data.new_users;
            this.pending_agency = response.data.pending_agency;
            this.pending_provider= response.data.pending_provider;
            this.pending_stories= response.data.pending_stories;
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
        Fire.$on('userRoleReload', response =>{});
        Fire.$on('Reload', response =>{
            $('#userModal').modal('hide'); 
            $('#roleModal').modal('hide');
            this.users = response.data.users;
        });
    },
}
</script>