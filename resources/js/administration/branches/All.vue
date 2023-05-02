<template>
<section>
    <div class="container-fluid">
        <div class="modal fade" id="branchModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-show="editMode">Edit Branch: {{branch.name}}</h4>
                        <h4 class="modal-title" v-show="!editMode">New Branch</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <AdminFormBranch :editMode="editMode"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Branches</h3>
                        <div class="card-tools">
                            <button class="btn btn-xs btn-primary" @click="addBranch">Add New</button>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-2" v-for="branch in branches.data" :key="branch.id">
                            <div class="card card-widget ">
                                <div class="card-body">
                                    <img class="img-fluid pad" src="" alt="branch_image" />
                                </div>
                                <div class="card-footer p-0">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                            {{ branch.name }} <span class="float-right badge bg-success">{{ branch.device_count }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <pagination :data="branches" @pagination-change-page="getAllInitials">
                            <span slot="prev-nav">&lt; Previous </span>
                            <span slot="next-nav">Next &gt;</span>
                        </pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</template>
<script>
export default {
    data(){
        return {
            branch: {},
            branches: {},
            editMode: false,
            form: new Form({}),
        }
    },
    methods:{
        addBranch(){
            this.branch = {};
            this.editMode = false;
            Fire.$emit('branchDataFill', {});
            $('#branchModal').modal('show'); 
        },
        closeModal(){
            $('#branchModal').modal('hide'); 
        },
        deleteBranch(id){
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
                    this.form.delete('/api/ums/branches/'+id)
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
        editBranch(branch){
            this.editMode = true;
            this.branch = branch;
            Fire.$emit('branchDataFill', branch);
            $('#branchModal').modal('show'); 
        },
        getAllInitials(page=1){
            this.$Progress.start();
            axios.get('/api/ums/branches?page='+page)
            .then(response =>{
                this.refresh(response);
                this.$Progress.finish();
                toast.fire({
                    icon: 'success',
                    title: 'Branches were loaded successfully',
                });
            })
            .catch(()=>{
                this.$Progress.fail();
                toast.fire({
                    icon: 'error',
                    title: 'Branches were not loaded successfully',
                })
            });
        },
        refresh(response){
            this.branches = response.data.branches;
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