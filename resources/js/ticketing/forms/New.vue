<template>
<div class="card">
    <h5 class="card-header d-flex justify-content-between align-items-baseline flex-wrap"><span>Create New Ticket</span></h5>
    <div class="card-body ">
        <form method="POST" action="http://localhost:8000/tickets" accept-charset="UTF-8">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="subject">Subject: </label>
                        <input class="form-control" required="required" name="subject" type="text" id="subject" v-model="ticketData.subject" :class="{'is-invalid' : ticketData.errors.has('subject') }">
                        <small class="form-text text-muted">A brief of your issue ticket</small>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="content" class="col-lg-2 col-form-label">Description: </label>
                        <textarea class="form-control summernote-editor" rows="5" required="required" name="content" cols="50" id="content" v-model="ticketData.content" :class="{'is-invalid' : ticketData.errors.has('content') }"></textarea>
                        <small class="form-text text-muted">Describe your issue here in details</small>        
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="priority" class="col-lg-6 col-form-label">Priority:</label>
                        <select class="form-control" required="required" name="priority_id" v-model="ticketData.priority_id" :class="{'is-invalid' : ticketData.errors.has('priority_id') }">
                            <option value="">--Select Priority--</option>
                            <option v-for="priority in priorities" :key="priority.id" :value="priority.id">{{priority.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="category" class="col-lg-6 col-form-label">Category:</label>
                        <select class="form-control" required="required" name="category_id" v-model="ticketData.category_id" :class="{'is-invalid' : ticketData.errors.has('category_id') }">
                            <option value="">--Select Category/Department--</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                        </select>
                    </div>
                    <input v-show="editMode" name="agent_id" type="hidden" value="" v-model="ticketData.agent_id" :class="{'is-invalid' : ticketData.errors.has('agent_id') }">
                </div>
                <div class="form-group row">
                    <div class="col-lg-10 offset-lg-2">
                        <button @click.prevent="editMode ? updateTicket() : createTicket()" type="submit" name="submit" class="submit btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return  {
            ticketData: new Form({
                'id': '',
                'subject': '',
                'description': '',
                'agent_id': 0,
                'category_id': '',
                'priority_id': '',                
            }),
        }
    },
    mounted() {
        Fire.$on('BioDataFill', user =>{
            this.BioData.fill(user);
        });
        Fire.$on('AfterCreation', ()=>{
            //axios.get("api/profile").then(({ data }) => (this.BioData.fill(data)));
        });
    },
    methods:{
        createTicket(){
            this.$Progress.start();
            this.ticketData.post('/api/tickets/ticket')
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('ticketReload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The Ticket has been created',
                    showConfirmButton: false,
                    timer: 1500
                });
                this.ticketData.reset();
                this.ticketData.clear();
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
        updateTicket(){
            console.log("Tested");
            this.$Progress.start();
            this.BioData.put('/api/ums/users/'+ this.BioData.id)
            .then(response =>{
                this.$Progress.finish();
                Fire.$emit('Reload', response);
                Swal.fire({
                    icon: 'success',
                    title: 'The User'+ response.data.user.first_name+' '+  response.data.user.last_name+' has been updated',
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
            let photo = (this.BioData.image.length >= 150) ? this.BioData.image : "./"+this.BioData.image;
            return photo;
        },
    },
    props:{
        priorities: Array,
        categories: Array, 
        departments: Array, 
        states: Array,
        user: Object,
        editMode: Boolean,
    }
}
</script>